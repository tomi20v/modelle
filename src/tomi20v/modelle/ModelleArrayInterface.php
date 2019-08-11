<?php

namespace tomi20v\modelle;

/**
 * ModelleArray is for scalars while ModelleCollection is for objects.
 * They share the same interface.
 */
interface ModelleArrayInterface extends \ArrayAccess, \Iterator
{

	const SCALAR_TYPES = ['bool','int','float','string'];

	public function all(): array;
	public function filter(callable $fn): ModelleArrayInterface;
	public function first();
	public function push($item);
	public function pop();
	public function remove($item);
}
