# php-mvc-framework
Building a MVC framework using PHP

The goal of this project is to build a simple implementation of a MVC framework using the PHP language.
Everything is kept as simple as possible, but nice and modern features are used.

Documentation still in progress, but for actual use, put all the framework's files and folders in a folder on your local server
and set the basePath in your bootstrap/app.php file.

Example:

<?php

$app = new System\Application();

$app['router']->setBasePath('mvc/public/');

$app->bind('HomeController', function() use ($app) {
	return new App\Controllers\HomeController($app['view']);
});

require_once BASE_PATH . 'app/routes.php';

$app->run();



