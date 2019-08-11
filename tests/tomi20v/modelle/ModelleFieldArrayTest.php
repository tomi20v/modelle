<?php

namespace tomi20v\modelle;

use tomi20v\modelle\Tester\FieldGetAsTester;

/**
 * @covers \tomi20v\modelle\Modelle
 */
class ModelleFieldArrayTest extends ModelleTestAbstract
{

    /** @var FieldGetAsTester */
    private $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new FieldGetAsTester($this->anyData);
    }

    public function testScalarArrayFieldReturnsCollection()
	{
		$field = $this->model->scalarArrayField;
		$this->assertInstanceOf(ModelleArrayInterface::class, $field);
	}

	public function testScalarArrayFieldContainsData()
	{
		$this->anyData->scalarArrayField = [1,5,3,98];
		$this->model = new FieldGetAsTester($this->anyData);
		$field = $this->model->scalarArrayField;
		$this->assertSame($this->anyData->scalarArrayField, $field->all());
	}

}
