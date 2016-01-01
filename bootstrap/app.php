<?php

$app = new System\Application();

$app['router']->setBasePath('mvc/public/');

$app->bind('HomeController', function() use ($app) {
	return new App\Controllers\HomeController($app['view']);
});

require_once BASE_PATH . 'app/routes.php';

$app->run();


