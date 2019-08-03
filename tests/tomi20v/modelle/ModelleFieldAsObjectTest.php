<?php

namespace tomi20v\modelle;

use tomi20v\modelle\Tester\FieldGetAsTester;

class ModelleFieldAsObjectTest extends ModelleTestAbstract
{

    /** @var FieldGetAsTester */
    private $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new FieldGetAsTester($this->anyData);
    }

    public function testReturnsSameObject()
	{

		$model = new FieldGetAsTester((object) [
			'objField' => (object) [
				'stringField' => 'any value',
			],
		]);
		$this->assertSame($model->objField, $model->objField);

	}

}
