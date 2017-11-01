<?php

namespace tomi20v\modelle;

use PHPUnit\Framework\TestCase;
use tomi20v\modelle\Tester\FieldDefaultTester;

class ModelTest extends TestCase
{

    private $anyData;

    private $anyAny = 'data';

    private $anyDoctype = 'anyDoctype';

    /** @var ModelInterface */
    private $model;

    public function setUp()
    {
        $this->anyData = (object) [
            'any' => $this->anyAny,
            'doctype' => $this->anyDoctype,
        ];
        $this->model = $this->getMockBuilder(Model::class)
            ->setConstructorArgs([$this->anyData])
            ->setMethods()
            ->getMock();
    }

    public function testConstruct()
    {
        $this->assertSame($this->anyData, $this->model->modelData());
    }

    public function testGetSetAnyField()
    {
        $other = 'other';
        $this->assertEquals($this->anyAny, $this->model->any);
        $this->model->any = $other;
        $this->assertEquals($other, $this->model->any);
    }

    public function testFieldGetsDefaulted()
    {
        $model = new FieldDefaultTester($this->anyData);
        $result = $model->defaulted;
        $modelleDef = FieldDefaultTester::MODELLE_DEF;
        $this->assertSame($modelleDef['defaulted']['default'], $result);
    }

    public function testFieldDoesntGetDefaultedIfSet()
    {
        $this->anyData->defaulted = $this->anyAny;
        $model = new FieldDefaultTester($this->anyData);
        $result = $model->defaulted;
        $this->assertSame($this->anyAny, $result);
    }

}
