<?php

namespace tomi20v\modelle\Tester;

use tomi20v\modelle\Model;

/**
 * @property bool boolField
 * @property int intField
 * @property float floatField
 * @property string stringField
 * @property string dateTimeField
 * @property FieldGetAsTester objField
 * @property bool notNullBoolField
 * @property int notNullIntField
 * @property float notNullFloatField
 * @property string notNullStringField
 * @property string notNullDateTimeField
 * @property FieldGetAsTester notNullObjField
 */
class FieldGetAsTester extends Model
{

    const MODELLE_DEF = [
        'boolField' => [
            'getAs' => 'bool'
        ],
        'intField' => [
            'getAs' => 'int',
        ],
        'floatField' => [
            'getAs' => 'float',
        ],
        'stringField' => [
            'getAs' => 'string',
        ],
        'objField' => [
            'getAs' => FieldGetAsTester::class,
        ],
        'notNullBoolField' => [
            'getAs' => 'bool',
            'notNull' => true,
        ],
        'notNullIntField' => [
            'getAs' => 'int',
            'notNull' => true,
        ],
        'notNullFloatField' => [
            'getAs' => 'float',
            'notNull' => true,
        ],
        'notNullStringField' => [
            'getAs' => 'string',
            'notNull' => true,
        ],
        'notNullObjField' => [
            'getAs' => FieldGetAsTester::class,
            'notNull' => true,
        ],
    ];

}
