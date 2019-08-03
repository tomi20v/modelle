<?php

namespace tomi20v\modelle;

use tomi20v\modelle\Tester\FieldGetAsTester;

class ModelleFieldGetAsTest extends ModelleTestAbstract
{

    /** @var FieldGetAsTester */
    private $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = new FieldGetAsTester($this->anyData);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testFieldBool($param)
    {
        $this->fieldTester('boolField', 'notNullBoolField', $param, (bool)$param);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testFieldInt($param)
    {
        $this->fieldTester('intField', 'notNullIntField', $param, (int)$param);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testFieldFloat($param)
    {
        $this->fieldTester('floatField', 'notNullFloatField', $param, (float)$param);
    }

    /**
     * @dataProvider paramProvider
     */
    public function testFieldString($param)
    {
        $this->fieldTester('stringField', 'notNullStringField', $param, (string)$param);
    }

    public function paramProvider()
    {
        return [
            [true],
            [false],
            [0],
            [1],
            [-2],
            ['a'],
            ['0'],
            [null],
        ];
    }

    /**
     * @dataProvider fieldProvider
     */
    public function testFieldReturnsNullIfNotFound($field)
    {
        $result = $this->model->$field;
        $this->assertNull($result);
    }

    public function fieldProvider()
    {
        return [
            ['boolField',],
            ['intField',],
            ['floatField',],
            ['stringField',],
            ['dateTimeField',],
            ['objField',],
        ];
    }

    public function testFieldObjCasts()
    {
        $fieldValue = 'inner field';
        $this->anyData->objField = (object) [
            'innerField' => $fieldValue,
        ];
        $result = $this->model->objField;
        $this->assertInstanceOf(FieldGetAsTester::class, $result);
        $this->assertSame($fieldValue, $result->innerField);
    }

    private function fieldTester($fieldName, $notNullFieldName, $param, $castValue)
    {
        $this->anyData->{$fieldName} = $param;
        $expected = is_null($param) ? null : $castValue;
        $result = $this->model->$fieldName;
        $this->assertSame($expected, $result);

        $this->anyData->$notNullFieldName = $param;
        $expected = $castValue;
        $result = $this->model->$notNullFieldName;
        $this->assertSame($expected, $result);
    }

}
