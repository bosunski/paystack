<?php

namespace Xeviant\Paystack\Tests\Model;

use Xeviant\Paystack\Model\Model;
use Xeviant\Paystack\Tests\TestCase;

class ModelTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateModelInstance()
    {
        $model = $this->getModel();

        $this->assertNotNull($model, 'Cannot create a Model instance');
    }

    /**
     * @test
     */
    public function canCreateModelInstanceWithAttributes()
    {
        $model = $this->getModel(['name' => 'bosun']);

        $this->assertNotNull($model, 'Cannot create model instance with attributes');
    }

    /**
     * @test
     */
    public function canRetrieveAttributes()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        $this->assertSame($model->getAttributes(), $attributes, 'Model did not return original attributes');
    }

    /**
     * @test
     */
    public function canRetrieveAnAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);

        $this->assertSame($model->getAttribute('name'), $attributes['name'], 'Model cannot retrieve an attribute');
    }

    /**
     * @test
     */
    public function canSetAttributesUsingFillMethod()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        $this->assertSame($model->getAttributes(), $attributes, 'Model Cannot set attributes using fill method');
    }

    /**
     * @test
     */
    public function canDynamicallyRetrievesAModelAttribute()
    {
        $attributes = ['name' => 'bosun'];
        $model = $this->getModel($attributes);
        $model->fill($attributes);

        $this->assertSame($model->name, $attributes['name'], 'Model cannot retrieve attribute dynamically.');
    }

    /**
     * @test
     */
    public function modelWillReturnNullIfAttributeNotExists()
    {
        $model = $this->getModel([]);
        $this->assertNull($model->name, 'Model did not return null when attribute is not set');
    }

    public function getModel($attributes = []): Model
    {
        return $this->createApplication()->make(Model::class, ['attributes' => $attributes]);
    }
}
