<?php

namespace Johnylemon\Apidocs\Params;

use Johnylemon\Apidocs\Traits\KeepsData;

class Param
{
    use KeepsData;

    public function __call(string $name, array $args = []): ?Param
    {
        if(in_array($name, ['string', 'array', 'bool', 'int']))
            return $this->type($name)->name($args[0]);

        return NULL;
    }

    /**
     * Set parameter type
     *
     * @param     string    $name    parameter name
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function type(string $name): Param
    {
        return $this->set('type', $name);
    }

    /**
     * Set parameter name (variable name)
     *
     * @param     string    $name    parameter name
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function name(string $name): Param
    {
        return $this->set('name', $name);
    }

    /**
     * Set parameter description
     *
     * @param     string    $description    parameter description
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function description(string $description): Param
    {
        return $this->set('description', $description);
    }

    /**
     * Set parameter description
     *
     *  Alias for `description`
     *
     * @see `description`
     * @param     string    $description    parameter description
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function desc(string $description): Param
    {
        return $this->description($description);
    }

    /**
     * Mark parameter as required
     *
     * @param     bool    $required
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function required(bool $required = TRUE): Param
    {
        return $this->set('required', $required);
    }

    /**
    * Mark parameter as optional
    *
    * @param     bool    $optional
    * @return    Johnylemon\Apidocs\Params\Param mutated parameter
    */
    public function optional(bool $optional = TRUE): Param
    {
        return $this->required(!$optional);
    }

    /**
    * Sets parameter possible values
    * Alias for `possible`
    *
    * @param     array    $enum possible values
    * @return    Johnylemon\Apidocs\Params\Param mutated parameter
    */
    public function enum(array $enum): Param
    {
        return $this->possible($enum);
    }

    /**
    * Sets parameter possible values.
    *
    * @see `enum`
    * @param     array    $possibilities possible values
    * @return    Johnylemon\Apidocs\Params\Param mutated parameter
    */
    public function possible(array $possiblities): Param
    {
        return $this->set('possible', $possiblities);
    }

    /**
     * Sets parameter default value
     *
     * @param     mixed    $default default value
     * @return    Johnylemon\Apidocs\Params\Param mutated parameter
     */
    public function default($default): Param
    {
        return $this->set('default', $default);
    }

    /**
    * Sets parameter example
    *
    * @param     mixed    $example parameter example value
    * @return    Johnylemon\Apidocs\Params\Param mutated parameter
    */
    public function example($example): Param
    {
        return $this->set('example', $example);
    }

    /**
    * Sets parameter example
    * Alias for `example`
    *
    * @see `example`
    * @param     mixed    $example parameter example value
    * @return    Johnylemon\Apidocs\Params\Param mutated parameter
    */
    public function eg($example): Param
    {
        return $this->example($example);
    }
}
