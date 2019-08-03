<?php

namespace tomi20v\modelle;

use PHPUnit\Framework\TestCase;

abstract class ModelleTestAbstract extends TestCase
{

    const RAW_DATA = [
        'any' => 'data',
        'doctype' => 'anyDoctype',
    ];

    protected $anyData;

    public function setUp()
    {
        $this->anyData = (object) static::RAW_DATA;
    }

}
