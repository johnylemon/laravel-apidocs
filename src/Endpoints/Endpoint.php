<?php

namespace Johnylemon\Apidocs\Endpoints;

use Johnylemon\Apidocs\Facades\Apidocs;
use Johnylemon\Apidocs\Traits\KeepsData;
use Johnylemon\Apidocs\Facades\Explain;
use Johnylemon\Apidocs\Params\Param;
use Johnylemon\Apidocs\Exceptions\InvalidParamValue;
use Johnylemon\Apidocs\Exceptions\GroupNotFound;
use Illuminate\Support\Str;
use Error;

class Endpoint
{
    use KeepsData;

    /**
     * Describe endpoint
     *
     */
    public function describe(): void
    {
        //
    }

    /**
     * Mounts endpoint within Apidocs container
     *
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function mount(): Endpoint
    {
        $this->describe();
        $this->set('id', "item-".Str::uuid());

        return $this;
    }

    /**
     * Sets endpoint method
     *
     * @param     string      $method    endpoint method
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function method(string $method): Endpoint
    {
        return $this->set('method', $method);
    }

    /**
     * Sets endpoint uri
     *
     * @param     string      $uri    endpoint uri
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function uri(string $uri): Endpoint
    {
        return $this->set('uri', $uri);
    }

    /**
    * Sets endpoint group
    *
    * @param     string      $slug    group slug
    * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
    * @throws    Johnylemon\Apidocs\Exceptions\GroupNotFound
    */
    public function group(string $slug): Endpoint
    {
        if(!Apidocs::groupDefined($slug))
            throw new GroupNotFound("Group `$slug` not found. Please register it");

        return $this->set('group', $slug);
    }

    /**
     * Sets endpoint group
     *
     * @param     boolean     $deprecated
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function deprecated(bool $deprecated = TRUE): Endpoint
    {
        return $this->set('deprecated', $deprecated);
    }

    /**
     * Sets endpoint title
     *
     * @param     boolean     $title endoint title
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function title(string $title): Endpoint
    {
        return $this->set('title', $title);
    }

    /**
     * Sets endpoint description
     *
     * @param     string     $description endoint description
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function description(string $description): Endpoint
    {
        return $this->set('description', $description);
    }

    /**
     * Sets endpoint description
     * Alias for `description`
     *
     * @see `description`
     * @param     string     $description endoint description
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function desc(string $description): Endpoint
    {
        return $this->description(...func_get_args());
    }

    /**
     * Sets endpoint query params
     *
     * @param     boolean     $data  query params
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function query(array $data): Endpoint
    {
        return $this->set("query", $this->buildParams($data));
    }

    /**
     * Sets endpoint route params
     *
     * @param     boolean     $data  route params
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function params(array $data): Endpoint
    {
        return $this->set("params", $this->buildParams($data));
    }

    /**
     * Sets endpoint route params
     *
     * @param     array      $data  body params
     * @param     string     $format  body format
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function body(array $data, string $format = ''): Endpoint
    {
        return $this->set("body.format", $format)
                ->set("body.data", $this->buildParams($data));
    }

    /**
     * Sets endpoint header
     *
     * @param     string     $key    header name
     * @param     string     $value  header value
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function header(string $key, string $value): Endpoint
    {
        return $this->headers([$key => $value]);
    }

    /**
     * Sets endpoint headers
     *
     * @param     array     $data    endpoint headers
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function headers(array $data): Endpoint
    {
        $headers = array_merge($this->get('headers', []), $data);

        return $this->set('headers', $headers);
    }

    /**
     * Sets endpoint example
     *
     * @param     mixed      $data     endpoint example
     * @param     string     $title    optional endpoint title
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function example($data, string $title = NULL): Endpoint
    {
        return $this->set('examples', [
            'title' => $title,
            'data' => (array)$data,
        ], TRUE);
    }

    /**
     * Sets endpoint examples
     *
     * @param     array      $data     endpoint examples
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function examples(array $data): Endpoint
    {
        foreach($data as $example)
            $this->example($example);

        return $this;
    }

    /**
     * Sets endpoint expected response
     *
     * @param     string     $code     response status code
     * @param     mixed      $data     endpoint response
     * @param     string     $data     optional response description
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint mutated endpoint
     */
    public function returns(string $code, $response, string $description = ''): Endpoint
    {
        $data = [
            'response' => (array)$response,
            'description' => $description,
        ];

        return $this->set("returns.$code", $data);
    }

    /**
     * Build parameters from given set
     *
     * @param     array    $params    parameters set
     * @return    array               properly built parameters array
     */
    protected function buildParams(array $params): array
    {
        return collect($params)->mapWithKeys(function($value, $key){
            $var = $this->resolveValue($value);
            $name = $this->guessVariableName($key, $var);

            return [
                $name => $var
            ];

        })->all();
    }

    /**
     * Resolve parameter values
     *
     * @param     mixed    $value
     * @return    array              param values
     * @throws    Johnylemon\Apidocs\Exceptions\InvalidParamValue
     */
    protected function resolveValue($value): array
    {
        if(is_array($value))
            return $value;

        if(is_string($value) && class_exists($value))
            $value = app($value);

        if($value instanceof Param)
            return $value->data();

        throw new InvalidParamValue;
    }

    /**
     * Guess variable name
     *
     * this method tries to guess real parameter name using
     * parameter `name` property. If not foud, parameter key will be returned
     *
     * @param     mixed     $key      parameter key
     * @param     array     $value    parameter values
     * @return    string              guessed variable name
     */
    protected function guessVariableName($key, array $value): string
    {
        if(is_numeric($key) && isset($value['name']))
            return $value['name'];

        return $key;
    }

    public function __call($name, $args)
    {
        if((string)$code = Str::of($name)->match('/^returns([0-9]{3})$/'))
        {
            return $this->returns($code, ...$args);
        }

        throw new Error('Call to undefined method '.__CLASS__.'::'.$name.'()');
    }
}
