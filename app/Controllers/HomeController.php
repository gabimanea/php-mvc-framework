<?php namespace App\Controllers;

use System\View;

use App\Models\User;

class HomeController
{
	protected $user;
	protected $view;

	public function __construct(View $view, User $user)
	{
		$this->user = $user;
		$this->view = $view;
	}

	public function index()
	{
		$this->view->render('index', ['message' => 'Hello']);
	}

	public function about()
	{
		$username = $this->user->getUsername();
		$this->view->render('about', ['name' => $username]);
	}
}