<?php

namespace Xeviant\Paystack\Model;

class Model
{
    /**
     * Model Attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        return $this->fill($attributes);
    }

    /**
     * Sets an attribute of the model
     *
     * @param string $key
     * @param $value
     * @return Model
     */
    public function setAttribute(string $key, $value): Model
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Retrieves all the attributes of the Model
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Retrieves an attribute of the Model
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        if (!$key) {
            return null;
        }

        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        return null;
    }

    /**
     * Populates the Model with values linked to keys
     *
     * @param array $attributes
     * @return Model
     */
    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value)  {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }
}
