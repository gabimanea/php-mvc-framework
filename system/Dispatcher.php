<?php namespace System;

class Dispatcher
{
	protected $app;
	protected $router;

	public function __construct(Application  $app)
	{
		$this->app = $app;
		$this->router = $this->app->getInstance('router');
	}

	public function dispatch()
	{
		$this->router->match();
		$result = $this->router->getResult();
		$params = $this->router->getParams();

		if (is_callable($result['call'])) {
			return call_user_func($result['call']);
		} else if (is_string($result['call'])) {
			$result = explode('@', $result['call']);
			$controller = $this->app->buildObject($result[0]);

			return call_user_func([$controller, $result[1]], $params);
		}
	}
}