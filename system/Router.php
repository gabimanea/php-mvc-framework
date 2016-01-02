<?php namespace System;

class Router
{
	protected $app;
	protected $request;
	protected $route;
	protected $routes = [];
	protected $basePath;
	protected $match = [];

	public function __construct(Application $app)
	{
		$this->app = $app;

		$this->request = $this->app->getInstance('request');
		$this->route = $this->app->getInstance('route');
	}

	public function setBasePath($basePath) 
	{
		$this->basePath = $basePath;
	}

	protected function setRoutes()
	{
		$this->routes = $this->route->getRoutes();

		if (count($this->routes) === 0) {
			throw new \Exception('Page not found!');
		}
	}

	protected function resolve()
	{
		$this->setRoutes();

		$method = $this->request->getAttribute('REQUEST_METHOD');
		$query  = $this->request->getAttribute('QUERY_STRING');

		$pattern = $this->request->getAttribute('REQUEST_URI');
		$pattern = str_replace($this->basePath, '', $pattern);
		$pattern = str_replace('?' . $query, '', $pattern);


		foreach ($this->routes as $route) {
			if ($method === $route['method']) {
				if ($pattern === $route['pattern']) {
					$this->match = $route;
					break;
				}
			}
		}
	}

	public function dispatch()
	{
		$this->resolve();

		if (count($this->match) === 0) {
			throw new \Exception('Page not found!');
		}

		if (is_callable($this->match['call'])) {
			return call_user_func($this->match['call']);
		} else if (is_string($this->match['call'])) {
			$call = explode('@', $this->match['call']);

			$controller = $this->app->resolve($call[0]);

			return $controller->$call[1]();
		}
	}
}