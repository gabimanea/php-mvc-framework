<?php namespace System;

class Application extends Container
{
	public function __construct() 
	{
		$this->setRequest();
		$this->setRouteCollection();
		$this->setRouter();
		$this->setView();
	}

	protected function setRequest()
	{
		$this->bind("request", function () {
			return new Request($_SERVER);
		});

		$this->singleton('request');
	}

	protected function setRouteCollection()
	{
		$this->bind("route", function () {
			return new RouteCollection();
		});

		$this->singleton('route');
	}

	protected function setRouter()
	{
		$this->bind('router', function () {
			$router = new Router($this);
			$router->setBasePath('mvc2/public/');

			return $router;
		});

		$this->singleton('router');
	}

	protected function setView()
	{
		$this->bind('view', function() {
			return new View();
		});
	}

	public function post($pattern, $call, $name = null) 
	{
		$this->getInstance('route')->createRoute("POST", $pattern, $call, $name);
	}

	public function get($pattern, $call, $name = null) 
	{
		$this->getInstance('route')->createRoute("GET", $pattern, $call, $name);
	}

	public function run()
	{
		$this->getInstance('router')->dispatch();

	}
}