<?php namespace System;

class Container implements \ArrayAccess
{
	/**
	 * Container bindings
	 * @var array
	 */
	protected $bindings = [];

	/**
	 * Instances created
	 * @var array
	 */
	protected $instances = [];

	/**
	 * Bind a new dependency
	 * 
	 * @param  string   $key
	 * @param  callable $closure
	 * @throws \Exception
	 */
	public function bind($key = null, callable $closure)
	{
		if ($key && is_callable($closure)) {
			$this->bindings[$key] = $closure;
		} else {
			throw new \Exception('The bind method needs a key name and a closure');
		}
	}

	/**
	 * Resolve a dependency from the $bindings array
	 * 
	 * @param  string $key
	 * @return mixed	 
	 **/
	public function resolve($key = null) 
	{
		if ($key) {
			if (isset($this->bindings[$key])) {
				return call_user_func($this->bindings[$key]);
			} else {
				throw new \Exception('The resolve method could not 
					found a match based on the provided key name');
			}
		} else {
			throw new \Exception('The resolve method needs a key name');
		}
	}

	/**
	 * Create a new instance of an already binded dependency
	 *
	 * @param  string $key
	 * @return [type]      [description]
	 */
	public function singleton($key = null)
	{
		if ($key) {
			$this->instances[$key] = $this->resolve($key);
		} else {
			\Exception('The singleton method needs the key of an already binded dependency');
		}
	}

	/**
	 * Retrieve an instance from the $instances array ( acts like a singleton )
	 * @param  string $key
	 * @throws \Exception
	 * @return object
	 */
	public function getInstance($key) 
	{
		if ($key) {
			if (isset($this->instances[$key]) && isset($this->bindings[$key])) {
				return $this->instances[$key];
			} else {
				throw new \Exception('The provided key name has to be first created as singleton');
			}
		} else {
			throw new \Exception('The getInstance method needs a key name');
		}
	}

	/**
	 * Whether on offset exists
	 * 
	 * @param  string  $key 
	 * @return boolean  
	 */
	public function offsetExists($key) 
	{
		return isset($this->bindings[$key]);
	}

	/**
	 * Offset to retrieve
	 * 
	 * @param  string $key 
	 * @return mixed  
	 */
	public function offsetGet($key) 
	{
		return $this->resolve($key);
	}

	/**
	 * Assign a value to the specified offset
	 * 
	 * @param  mixed $key 
	 * @param  mixed $value
	 */
	public function offsetSet($key, $value) 
	{
		$this->bind($key, $value);
	}

	/**
	 * Unset an offset
	 * 
	 * @param  string $key
	 */
	public function offsetUnset($key) 
	{
		unset($this->bindings[$key]);
		reset($this->bindings);
	}
}