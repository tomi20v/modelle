<?php

namespace tomi20v\modelle;

use Exception;

class ModelleCollection extends ModelleArray implements ModelleArrayInterface
{

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

	public function all(): array
    {
	    foreach ($this->data as &$each) {
	        if (!$each instanceof ModelleInterface) {
	            $itemClass = $this->itemClass;
	            $each = new $itemClass($each);
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

	public function push($item)
	{
		$this->data[] = $item;
	}

	public function pop()
	{
		return $this->instanciate(array_pop($this->data));

	}

	public function remove($item)
	{
		foreach ($this->data as &$eachData) {
			if ($eachData === $item) {
				unset($eachData);
			}
		}
	}

	/**
	 * @return object of class of this collection
	 */
	public function current()
	{
        $ret = current($this->data);
        if (!$ret instanceof ModelleInterface) {
            $index = array_search($ret, $this->data);
            $this->data[$index] = $this->instanciate($this->data[$index]);
            $ret = $this->data[$index];
        }
        return $ret;
	}

	/**
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		next($this->data);
	}

	/**
	 * Return the key of the current element
	 *
	 * @link https://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key()
	{
		return key($this->data);
	}

	/**
	 * Checks if current position is valid
	 *
	 * @link https://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid()
	{
		return valid($this->data);
	}

	/**
	 * Rewind the Iterator to the first element
	 *
	 * @link https://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function rewind()
	{
		return reset($this->data);

	}

	private function instanciate($data) {
	    $className = $this->itemClass;
	    return new $className($data);
    }
}
