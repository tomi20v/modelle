<?php

namespace tomi20v\modelle;

class ModelleTest extends ModelleTestAbstract
{

    protected $anyData;

    /** @var ModelleInterface */
    private $model;

    public function setUp()
    {
        parent::setUp();
        $this->model = $this->getMockBuilder(Modelle::class)
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
        $this->assertEquals(static::RAW_DATA['any'], $this->model->any);
        $this->model->any = $other;
        $this->assertEquals($other, $this->model->any);
    }

}
