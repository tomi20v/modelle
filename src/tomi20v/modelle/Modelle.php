<?php

namespace tomi20v\modelle;

abstract class Modelle implements ModelleInterface
{

    const MODELLE_DEF = [];

    private $data;

    private $instances = [];

    public function __construct(&$data)
    {
        if (!is_object($data)) {
            $data = (object)$data;
        }
        $this->data = $data;
    }

	/**
	 * @param string $field
	 * @return bool|float|int|mixed|string|null
	 * @throws \Exception
	 */
	public function __get(string $field)
    {

        $ret = null;
        $meta = isset(static::MODELLE_DEF[$field]) ? static::MODELLE_DEF[$field] : null;
        if (is_string($meta)) {
        	$metaParts = explode('|', $meta);
        	$meta = [
				'getAs' => $metaParts[0],
				'notNull' => (bool)$metaParts[1],
				'default' => $metaParts[2],
			];
		}
        if (isset($meta['getAs']) && is_array($meta['getAs'])) {
			$meta['arrayType'] = $meta['getAs'][0];
			$meta['getAs'] = 'array';
		}

		if (isset($this->data->{$field})) {
			$ret = $this->data->{$field};
		}
		elseif (isset($meta['default'])) {
			$ret = $meta['default'];
		}
        $notNull = isset($meta['notNull']) && $meta['notNull'];

        if (isset($meta['getAs']) && (!is_null($ret) || $notNull || ($meta['getAs'] === 'array'))) {
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
			case 'array':
				if (!isset($this->data->{$field})) {
					$this->data->{$field} = [];
				}
				if (!array_key_exists($field, $this->instances)) {
                    $this->instances[$field] = new ModelleArray($this->data->{$field}, $meta['arrayType']);
				}
				$ret = $this->instances[$field];
				break;
            default:
            	if (!array_key_exists($field, $this->instances)) {
					$this->instances[$field] = new $getAs($ret);
				}
                $ret = $this->instances[$field];
                break;
            }
        }

        return $ret;

    }

    public function __set($field, $val)
    {
        $this->data->{$field} = $val;
    }

    public function modelData()
    {
        return $this->data;
    }

}
