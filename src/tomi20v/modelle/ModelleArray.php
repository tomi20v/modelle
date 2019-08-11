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
//    private $instances;

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
            $this->data[] = $value;
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
        $ret = current($this->data);
        if (!$this->isScalar && !($ret instanceof ModelleInterface)) {
            $index = array_search($ret, $this->data);
            $this->data[$index] = $this->instanciate($this->data[$index]);
            $ret = $this->data[$index];
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
                    $itemClass = $this->itemClass;
                    $each = new $itemClass($each);
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
		$modelClass = $this->itemClass;
    	if ($dataOrItem instanceof $modelClass) {
    		$data = $dataOrItem->modelData();
    		$item = $dataOrItem;
		}
    	elseif (is_array($dataOrItem)) {
    		$data = $dataOrItem;
    		// @todo I should use Modelle->applyArray here
    		$item = new $modelClass($data);
		}
		else {
			throw new ModelleException('object type not supported');
		}

		$this->data[] = $data;
		$key = last(array_keys($this->data));
//		$this->instances[$key] = $item;

    }

    public function pop()
    {
        return $this->instanciate(array_pop($this->data));

    }

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
}
