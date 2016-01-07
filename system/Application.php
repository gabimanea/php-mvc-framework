<?php namespace System;

class Application extends Container
{
	public function __construct()
	{
		$this->setRequest();
		$this->setRouteCollection();
		$this->setRouter();
		$this->setDispatcher();
	}

	protected function setRequest()
	{
		$this->save('request', function() {
			return new Request($_SERVER);
		});

		$this->saveInstance('request');
	}

	protected function setRouteCollection()
	{
		$this->save('route', function() {
			return new RouteCollection();
		});

		$this->saveInstance('route');
	}

	protected function setRouter()
	{
		$this->save('router', function() {
			return new Router(
				$this->getInstance('request'), 
				$this->getInstance('route'), 'mvc3/public/'
			    );
		});

		$this->saveInstance('router');
	}

	protected function setDispatcher()
	{
		$this->save('dispatcher', function() {
			return new Dispatcher($this);
		});

		$this->saveInstance('dispatcher');
	}

	public function get($pattern, $call, $name = null)
	{
		$this->getInstance('route')->createRoute("GET", $pattern, $call, $name);
	}

	public function post($pattern, $call, $name = null)
	{
		$this->getInstance('route')->createRoute("POST", $pattern, $call, $name);
	}		

	public function run()
	{
		$this->getInstance('dispatcher')->dispatch();
	}
}