<?php

namespace Xeviant\Paystack\Model;

use ArrayAccess;
use Xeviant\Paystack\Contract\ApplicationInterface;

class Model implements ArrayAccess
{
    /**
     * Model Attributes.
     *
     * @var array
     */
    protected $attributes = [];
    /**
     * @var
     */
    private $application;

    /**
     * Model constructor.
     *
     * @param array                $attributes
     * @param ApplicationInterface $application
     */
    public function __construct(array $attributes, ApplicationInterface $application)
    {
        $this->fill($attributes);
        $this->application = $application;
    }

    /**
     * Sets an attribute of the model.
     *
     * @param string $key
     * @param $value
     *
     * @return Model
     */
    public function setAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Retrieves all the attributes of the Model.
     *
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * Retrieves an attribute of the Model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute(string $key)
    {
        if (!$key) {
            return;
        }

        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    /**
     * Populates the Model with values linked to keys.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function fill(array $attributes): self
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Whether a offset exists.
     *
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return bool true on success or false on failure.
     *              </p>
     *              <p>
     *              The return value will be casted to boolean if non-boolean was returned.
     *
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return !is_null($this->getAttribute($offset));
    }

    /**
     * Offset to retrieve.
     *
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     *
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Offset to set.
     *
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     *
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->setAttribute($offset, $value);
    }

    /**
     * Offset to unset.
     *
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     *
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }
}
