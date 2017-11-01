<?php

namespace tomi20v\modelle;

use tomi20v\modelle\Tester\FieldDefaultTester;

class ModelFieldDefaultTest extends ModelTestAbstract
{

    public function testFieldGetsDefaulted()
    {
        $model = new FieldDefaultTester($this->anyData);
        $result = $model->defaulted;
        $modelleDef = FieldDefaultTester::MODELLE_DEF;
        $this->assertSame($modelleDef['defaulted']['default'], $result);
    }

    public function testFieldDoesntGetDefaultedIfSet()
    {
        $anyValue = 'anyValue';
        $this->anyData->defaulted = $anyValue;
        $model = new FieldDefaultTester($this->anyData);
        $result = $model->defaulted;
        $this->assertSame($anyValue, $result);
    }

}
