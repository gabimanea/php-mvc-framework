<?php namespace System;


class Container
{
	/**
	 * Contains pairs of key\callable elements
	 * 
	 * @var array
	 */
	private $container = [];

	/**
	 * Contains pairs of key\instances elements
	 * 
	 * @var array
	 */
	private $instances = [];

	/**
	 * Save the pair key\callable in container's array
	 * 
	 * @param  string   $key      An alias
	 * @param  callable $callable Closure
	 */
	public function save($key, callable $callable) 
	{
		$this->container[$key] = $callable;
	}

	/**
	 * Create a new intance for a given alias from container
	 * 
	 * @param  string $key Alias
	 * @return Object
	 * @throws \Exception
	 */
	public function createInstance($key) 
	{
		if ($this->container[$key]) {
			return $this->container[$key]();
		}

		throw new \Exception("[$key] is not available in the container");
	}

	/**
	 * Save an instance for a given alias from the container's array
	 * 
	 * @param  string $key Alias
	 */
	public function saveInstance($key) 
	{
		$this->instances[$key] = $this->createInstance($key);
	}

	/**
	 * Get an intance for a given alias from the instances's array
	 * 
	 * @param  string $key Alias
	 * @return Object
	 * @throws \Exception
	 */
	public function getInstance($key) 
	{
		if ($this->instances[$key]) {
			return $this->instances[$key];
		}

		throw new \Exception("No instance saved in container for [$key]");
	}

	/**
	 * Build and object and object's dependencies
	 * 
	 * @param  string $className 
	 * @return Object
	 * @throws \Exception
	 */
	public function buildObject($className) 
	{
		// create a ReflectionClass object and pass the $className
		$reflector = new \ReflectionClass($className);

		// check if the inspected class can be instantiated
		if (!$reflector->isInstantiable()) {
			throw new \Exception("[$className] is not instantiable");
		}

		// get the constructor of the class
		// if exists, it returns a ReflectionMethod object
		$constructor = $reflector->getConstructor();

		// check if constructor exists, otherwise return a new object of the class
		if (!$constructor) {
			return new $className();
		}

		// get constructor parameters in an array as ReflectionParameter objects
		// return an empty array if no parameters are found
		$parameters = $constructor->getParameters();

		// build object's dependencies
		$dependencies = $this->BuildObjectDependencies($parameters);

		// return a new instance of the inspected class
		// passing all the dependencies in the constructor
		return $reflector->newInstanceArgs($dependencies);
	}

	/**
	 * Build object's dependencies
	 * 
	 * @param  array $parameters
	 * @return array
	 */
	protected function buildObjectDependencies($parameters)
	{
		// store dependencies here
		$dependencies = [];

		foreach ($parameters as $parameter) {
			// check if parameter has a class as type hint
			$dependency = $parameter->getClass();

			if (!is_null($dependency)) {
				// perform the steps from BuildObject() method to all parameters
				$dependencies[] = $this->buildObject($parameter->getClass()->name);

			} else {
				// verify the parameters without a type hinted class
				$dependencies[] = $this->buildObjectUnknownDependencies($parameter);
			}
		}

		return $dependencies;
	}

	/**
	 * Build object's dependencies that are unknown
	 * 
	 * @param  string $parameter 
	 * @return mixed
	 * @throws  \Exception
	 */
	protected function buildObjectUnknownDependencies($parameter)
	{
		// check if parameter has default value
		if ($parameter->isDefaultValueAvailable()) {
			return $parameter->getDefaultValue();
		}
		
		throw new \Exception("There was a problem building the object");
	}
}