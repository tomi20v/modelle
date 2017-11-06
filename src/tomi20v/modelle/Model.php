<?php

namespace tomi20v\modelle;

abstract class Model implements ModelInterface
{

    const MODELLE_DEF = [];

    private $data;

    public function __construct(
        $data
    ) {
        $this->data = $data;
    }

    public function __get(string $field)
    {

        $ret = null;
        $meta = isset(static::MODELLE_DEF[$field]) ? static::MODELLE_DEF[$field] : null;

        switch ($field) {
        default:
            if (isset($this->data->{$field})) {
                $ret = $this->data->{$field};
            }
            elseif (isset($meta['default'])) {
                $ret = $meta['default'];
            }
        }

        $notNull = isset($meta['notNull']) && $meta['notNull'];
        if (isset($meta['getAs']) && (!is_null($ret) || $notNull)) {
            $getAs = $meta['getAs'];
            switch ($getAs) {
            case 'bool':
                $ret = (bool) $ret;
                break;
            case 'int':
                $ret = (int) $ret;
                break;
            case 'float':
                $ret = (float) $ret;
                break;
            case 'string':
                $ret = (string) $ret;
                break;
            default:
                $ret = new $getAs($ret);
                break;
            }
        }

        return $ret;

    }

    public function __set($field, $val)
    {
        $this->data->$field = $val;
    }

    public function modelData()
    {
        return $this->data;
    }

}
