<?php

namespace tomi20v\modelle;

class Model implements ModelInterface
{

    private $data;

    public function __construct(
        $data
    ) {
        $this->data = $data;
    }

    public function __get(string $field)
    {
        $ret = null;
        switch ($field) {
        default:
            if (isset($this->data->{$field})) {
                $ret = $this->data->{$field};
            }
        }
        return $ret;
    }

    public function modelData()
    {
        return $this->data;
    }

}
