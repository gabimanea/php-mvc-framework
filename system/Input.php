<?php namespace System;

class Input
{
	protected $input = [];

	public function __construct(array $get = [], array $post = [])
	{
		$this->setGetData($get);
		$this->setPostData($post);
	}

	protected function setGetData($get)
	{
		$this->input['get'] = $get;
	}

	protected function setPostData($post)
	{
		$this->input['post'] = $post;
	}

	public function get($key)
	{
		if (isset($this->input['get'][$key])) {
			return htmlspecialchars($this->input['get'][$key], ENT_QUOTES, 'utf-8');
		}
	}

	public function post($key)
	{
		if (isset($this->input['post'][$key])) {
			return htmlspecialchars($this->input['post'][$key], ENT_QUOTES, 'utf-8');
		}	
	}
}