<?php

namespace Johnylemon\Apidocs;

use Johnylemon\Apidocs\Facades\Exporter;
use Johnylemon\Apidocs\Endpoints\Endpoint;
use Johnylemon\Apidocs\Exceptions\InvalidEndpoint;
use Route;

class Apidocs
{
    /**
     * registered endpoints
     * @var    array
     */
    protected $routes = [];

    /**
     * defered endpoint definitions
     * @var    array
     */
    protected $defered = [];

    /**
     * registered groups
     * @var    array
     */
    protected $groups = [];

    /**
     * Register endpoint
     *
     * @param     mixed    $data    endpoint
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint endpoint
     */
    public function register($data): Endpoint
    {
        $endpoint = static::buildEndpoint($data);

        $this->routes[] = $endpoint;

        return $endpoint;
    }

    /**
     * Register endpoint
     *
     * @param     mixed    $data    endpoint
     * @param     mixed    $route   route
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint endpoint
     */
    public function registerRoute($data, $route): Endpoint
    {
        return $this->register($data)
            ->method($route->methods()[0])
            ->uri($route->uri())
            ->group('non-groupped')
            ->mount();
    }

    /**
     * Build endpoint using provided data
     *
     * @param     mixed      $data    endpoint data
     * @return    Johnylemon\Apidocs\Endpoints\Endpoint endpoint
     * @throws    Johnylemon\Apidocs\Exceptions\InvalidEndpoint
     */
    protected function buildEndpoint($data): Endpoint
    {
        if(!$data)
            return app(Endpoint::class);

        if(is_string($data) && class_exists($data))
            return app($data);

        if($data instanceof Endpoint)
            return $data;

        throw new InvalidEndpoint;
    }

    /**
     * Create endpoint definitions for all of the routes
     *
     */
    protected function compile()
    {
        if($this->defered)
        {
            $this->describeDefered();
        }
    }

    /**
     * Create endpoint definitions for defered routes
     *
     */
    protected function describeDefered()
    {
        $routes = Route::getRoutes();

        foreach($this->defered as $name => $definition)
        {
            if($route = $routes->getByName($name))
                $this->registerRoute($definition, $route);
        }

        $this->defered = [];
    }

    /**
     * Exports apidocs data
     *
     * @return    array    array of data
     */
    public function export(): array
    {
        $this->compile();

        return Exporter::export($this);
    }

    /**
     * Returns all registered endpoints
     *
     * @return    array    registered endpoints
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Define group of endpoints
     *
     * @param     string    $slug           group friendly name
     * @param     string    $name           group name
     * @param     string    $description    group description
     */
    public function defineGroup(string $slug, string $name, string $description = NULL)
    {
        $this->groups[$slug] = [
            'name' => $name,
            'description' => $description,
        ];
    }

    /**
     * Returns all defned groups
     *
     * @return    array    groups
     */
    public function groups(): array
    {
        return $this->groups;
    }

    /**
     * Check if group has been defined
     *
     * @param     string    $slug    group friendly name
     * @return    bool
     */
    public function groupDefined(string $slug): bool
    {
        return isset($this->groups[$slug]);
    }

    /**
     * Returns group by its friendly name
     *
     * @param     string    $slug    group friendly name
     * @return    array              group data
     */
    public function getGroup(string $slug): array
    {
        return $this->groups[$slug];
    }

    /**
     * Defer endpoint definition
     *
     * @param     array     $definitions
     */
    public function defer(array $definitions)
    {
        $this->defered = array_merge($this->defered, $definitions);
    }
}
