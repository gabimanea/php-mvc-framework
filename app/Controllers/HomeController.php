<?php namespace App\Controllers;

class HomeController
{
	protected $view;

	public function __construct(\System\View $view)
	{
		$this->view = $view;
	}

	public function index()
	{
		$this->view->render('index');
	}

	public function about($args)
	{
		var_dump($args);
	}
}