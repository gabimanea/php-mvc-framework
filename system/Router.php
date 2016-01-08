<?php namespace System;

class Router
{
	protected $request;
	protected $route;
	protected $routes = [];
	protected $urlPattern;
	protected $basePath;
	protected $match = [];
	protected $params = [];

	public function __construct(Request $request, RouteCollection $route, $basePath)
	{
		$this->request = $request; 
		$this->route   = $route;

		$this->setBasePath($basePath);
	}

	public function setBasePath($basePath)
	{
		$this->basePath = $basePath;
	}

	protected function setRoutes()
	{
		$this->routes = $this->route->getRoutes();

		if (count($this->routes) === 0) {
			throw new \Exception("There are no routes defined yet!");
		}
	}

	protected function setUrlPattern()
	{
		$queryString = $this->request->getAttribute('QUERY_STRING');
		$this->urlPattern = $this->request->getAttribute('REQUEST_URI');
		$this->urlPattern = str_replace($this->basePath, '', $this->urlPattern);
		$this->urlPattern = str_replace('?' . $queryString, '', $this->urlPattern);
	}

	public function match()
	{
		$this->setRoutes();
		$this->setUrlPattern();

		$method = $this->request->getAttribute('REQUEST_METHOD');

		foreach ($this->routes as $route) {
			if ($route['method'] === $method) {
				if ($this->urlPattern === $route['pattern'] && $this->urlPattern === '/') {
					$this->match = $route;
					break;
				} else {
					$this->urlPattern = rtrim($this->urlPattern, '/');
					$urlElements = explode('/', $this->urlPattern);
					$routeElements = explode('/', $route['pattern']);

					$countUrlElements = count($urlElements);
					$countRouteElements = count($routeElements);

					if ($countUrlElements === $countRouteElements) {
						if ($this->urlPattern === $route['pattern']) {
							$this->match = $route;
							break;
						} else {
							$countRouteParams = substr_count($route['pattern'], ':');

							$start = $countRouteElements - $countRouteParams;

							for ($x = $start; $x < $countRouteElements; $x++) {
								if (isset($urlElements[$x])) {
									$routeElements[$x] = str_replace(':', '', $routeElements[$x]);
									$this->params[$routeElements[$x]] = $urlElements[$x];
									$this->match = $route;
								} else {
									throw new \Exception('Page not found!');
								}
							}

						}
					}

				}
			}
		}
	}

	public function getParams()
	{
		return $this->params;
	}

	public function getResult()
	{
		return $this->match;
	}


}
