<?php

namespace Xeviant\Paystack\Tests\Model;

use Xeviant\Paystack\Model\Model;
use Xeviant\Paystack\Tests\TestCase;

class ModelTest extends TestCase
{
    public function testCanCreateModelInstance()
    {
        $model = $this->getModel();

        $this->assertNotNull($model, 'Cannot create a Model instance');
    }

    public function testCanCreateModelInstanceWithAttributes()
    {
        $model = $this->getModel(['name' => 'bosun']);

        $this->assertNotNull($model, 'Cannot create model instance with attributes');
    }

    public function testCanRetrieveAttributes()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        $this->assertSame($model->getAttributes(), $attributes, 'Model did not return original attributes');
    }

    public function testCanRetrieveAnAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        $this->assertSame($model->getAttribute('name'), $attributes['name'], 'Model cannot retrieve an attribute');
    }

    public function testCanSetAttributesUsingFillMethod()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        $this->assertSame($model->getAttributes(), $attributes, 'Model Cannot set attributes using fill method');
    }

    public function testCanDynamicallyRetrievesAModelAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        $this->assertSame($model->name, $attributes['name'], 'Model cannot retrieve attribute dynamically.');
    }

    public function testModelWillReturnNullIfAttributeNotExists()
    {
        $model = $this->getModel([]);
        $this->assertNull($model->name, 'Model did not return null when attribute is not set');
    }

    public function getModel($attributes = []): Model
    {
        return $this->createApplication()->make(Model::class, ['attributes' => $attributes]);
    }
}
