<?php

namespace Xeviant\Paystack\Tests\Model;

use Xeviant\Paystack\Model\Model;
use Xeviant\Paystack\Tests\TestCase;

class ModelTest extends TestCase
{
    public function testCanCreateModelInstance()
    {
        $model = $this->getModel();

        self::assertNotEquals(null, $model, 'Cannot create a Model instance');
    }

    public function testCanCreateModelInstanceWithAttributes()
    {
        $model = $this->getModel(['name' => 'bosun']);

        self::assertNotEquals(null, $model, 'Cannot create model instance with attributes');
    }

    public function testCanRetrieveAttributes()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        self::assertSame($model->getAttributes(), $attributes, 'Model did not return original attributes');
    }

    public function testCanRetrieveAnAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        self::assertSame($model->getAttribute('name'), $attributes['name'], 'Model cannot retrieve an attribute');
    }

    public function testCanSetAttributesUsingFillMethod()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        self::assertSame($model->getAttributes(), $attributes, 'Model Cannot set attributes using fill method');
    }

    public function testCanDynamicallyRetrievesAModelAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        self::assertSame($model->name, $attributes['name'], 'Model cannot retrieve attribute dynamically.');
    }

    public function testModelWillReturnNullIfAttributeNotExists()
    {
        $model = $this->getModel([]);
        self::assertNull($model->name, 'Model did not return null when attribute is not set');
    }

    public function getModel($attributes = [])
    {
        return $this->createApplication()->make(Model::class, ['attributes' => $attributes]);
    }
}
