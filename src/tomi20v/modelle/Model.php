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

        return $ret;

    }

    public function modelData()
    {
        return $this->data;
    }

}
