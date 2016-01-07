<?php namespace System;

class Request
{
	protected $attributes = [];

	public function __construct(array $server = [])
	{
		$this->attributes = $server;
	}

	public function getAttribute($key)
	{
		if (isset($this->attributes[$key]))
		{
			return $this->attributes[$key];
		}
	}
}