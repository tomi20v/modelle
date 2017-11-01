<?php

namespace tomi20v\modelle;

use PHPUnit\Framework\TestCase;

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
        $this->model = new Model($this->anyData);
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

}
