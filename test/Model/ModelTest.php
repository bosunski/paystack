<?php

namespace Xeviant\Paystack\Tests\Model;

use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\Model\Model;

class ModelTest extends TestCase
{
    public function testCanCreateModelInstance()
    {
        $model = new Model();

        self::assertNotEquals(null, $model, 'Cannot create a Model instance');
    }

    public function testCanCreateModelInstanceWithAttributes()
    {
        $model = new Model(['name' => 'bosun']);

        self::assertNotEquals(null, $model, 'Cannot create model instance with attributes');
    }

    public function testCanRetrieveAttributes()
    {
        $attributes = ['name' => 'bosun'];
        $model = new Model($attributes);

        self::assertSame($model->getAttributes(), $attributes, 'Model did not return original attributes');
    }

    public function testCanRetrieveAnAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = new Model($attributes);

        self::assertSame($model->getAttribute('name'), $attributes['name'], 'Model cannot retrieve an attribute');
    }

    public function testCanSetAttributesUsingFillMethod()
    {
        $attributes = ['name' => 'bosun'];
        $model = new Model();
        $model->fill($attributes);

        self::assertSame($model->getAttributes(), $attributes, 'Model Cannot set attributes using fill method');
    }

    public function testCanDynamicallyRetrievesAModelAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = new Model();
        $model->fill($attributes);

        self::assertSame($model->name, $attributes['name'], 'Model cannot retrieve attribute dynamically.');
    }

    public function testModelWillReturnNullIfAttributeNotExists()
    {
        $model = new Model([]);
        self::assertNull($model->name, 'Model did not return null when attribute is not set');
    }
}
