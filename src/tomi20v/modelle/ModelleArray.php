<?php

namespace tomi20v\modelle;

use Exception;

class ModelleArray implements ModelleArrayInterface
{

    /** @var array  */
    private $data;
    /** @var string */
    private $itemClass;
    private $isScalar;
    private $instances;

    public function __construct(array &$data, $itemClass)
    {
        $this->data = &$data;
        $this->itemClass = $itemClass;
        $this->isScalar = in_array($itemClass, ModelleArrayInterface::SCALAR_TYPES);
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// ArrayAccess interface (only lets push, throws otherwise)
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param mixed $offset <p>
     * @return boolean true on success or false on failure.
     * @throws Exception
     */
    public function offsetExists($offset)
    {
        throw new Exception('no direct access');
    }

    /**
     * @param mixed $offset <p>
     * @return mixed Can return all value types.
     * @throws Exception
     */
    public function offsetGet($offset)
    {
        throw new Exception('no direct access');
    }

    /**
     * @param mixed $offset <p>
     * @param mixed $value <p>
     * @return void
     * @throws Exception
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
			$this->push($value);
        }
        else {
            throw new Exception('no direct access');
        }
    }

    /**
     * @param mixed $offset <p>
     * @return void
     * @throws Exception
     */
    public function offsetUnset($offset)
    {
        throw new Exception('no direct access');
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// Iterator interface
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return object of class of $this->itemClass
     */
    public function current()
    {
		$key = key($this->data);
		if ($this->isScalar) {
			$ret = $this->data[$key];
		}
		elseif (!array_key_exists($key, $this->instances)) {
			$this->instances[$key] = $this->instanciate($this->data[$key]);
			$ret = $this->instances[$key];
		}
        return $ret;
    }

    public function next()
    {
        next($this->data);
    }

    /**
     * Return the key of the current element
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Checks if current position is valid
     */
    public function valid()
    {
        return !is_null(key($this->data));
    }

    public function rewind()
    {
        reset($this->data);
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// ModelleArrayInterface
    ////////////////////////////////////////////////////////////////////////////////

    public function all(): array
    {
        if (!in_array($this->itemClass, ModelleArrayInterface::SCALAR_TYPES)) {
            foreach ($this->data as &$each) {
                if (!$each instanceof ModelleInterface) {
					$each = $this->instanciate($each);
                }
            }
        }
        return $this->data;
    }

    public function toArray(): array
    {
        $ret = $this->data;
        foreach ($ret as $eachKey => $eachVal) {
            if ($eachVal instanceof ModelleInterface) {
                $ret[$eachKey] = $eachVal->modelData();
            }
        }
        return $ret;
    }

    public function filter(callable $fn): ModelleArrayInterface
    {
        return new ModelleCollection(array_filter($this->data, $fn), $this->itemClass);
    }

    public function first()
    {
        $firstKey = reset(array_keys($this->data));
        return $firstKey ? $this->data[$firstKey] : null;
    }

    public function push($dataOrItem)
    {
		list($data, $item) = $this->castData($dataOrItem);
		$this->data[] = $data;
		$key = last(array_keys($this->data));
		$this->instances[$key] = $item;

    }

    public function pop()
    {
        return $this->instanciate(array_pop($this->data));
    }

	/**
	 * @param $item must be object of correct class. Use remove only with items got from this class eg don't remove manually created objects it won't work even if they match
	 */
    public function remove($item)
    {
        foreach ($this->data as $eachKey => $eachValue) {
            if ($eachValue === $item) {
                unset($this->data[$eachKey]);
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////
    /// the rest
    ////////////////////////////////////////////////////////////////////////////////

    private function instanciate($data) {
        $className = $this->itemClass;
        return new $className($data);
    }

	private function castData($dataOrItem)
	{
		$modelClass = $this->itemClass;
		if ($dataOrItem instanceof $modelClass) {
			$data = $dataOrItem->modelData();
			$item = $dataOrItem;
		}
		elseif (is_array($dataOrItem)) {
			$data = (object)$dataOrItem;
			// @todo I should use Modelle->applyArray here
			$item = $this->instanciate($data);
		}
		elseif ($dataOrItem instanceof \stdClass) {
			$data = $dataOrItem;
			$item = new $modelClass($data);
		}
		else {
			throw new ModelleException('object type not supported');
		}
		return [$data, $item];
	}
}
