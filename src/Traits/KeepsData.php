<?php

namespace Johnylemon\Apidocs\Traits;

use Illuminate\Support\Arr;

trait KeepsData
{
    /**
     * data holder
     * @var    array
     */
    protected $data = [];

    /**
     * Set value under desired key
     *
     * @param     string     $key       variable name
     * @param     mixed      $value     value
     * @param     boolean    $append    will add value as new aray item instead of overwrite
     * @return    self
     */
    public function set(string $key, $value, bool $append = FALSE): self
    {
        if($append)
        {
            $current = $this->get($key, []);
            $current[] = $value;

            return $this->set($key, $current);
        }

        Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * Remove variable from set
     *
     * @param     string    $key    variable name
     * @return    self
     */
    public function remove(string $key): self
    {
        Arr::forget($this->data, $key);

        return $this;
    }

    /**
     * Returns variable by the key
     *
     * @param     string    $key        variable name
     * @param     mixed     $default    default value
     * @return    mixed                 value
     */
    public function get(string $key, $default = NULL)
    {
        return Arr::get($this->data, $key, $default);
    }

    /**
     * Magic getter
     */
    public function __get(string $key)
    {
        return $this->get($key);
    }

    /**
     * Return all values
     * 
     * @return    array    values
     */
    public function data(): array
    {
        return $this->data;
    }
}
