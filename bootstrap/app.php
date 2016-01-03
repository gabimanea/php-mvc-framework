<?php

$app = new System\Application();

$app->getInstance('router)->setBasePath('mvc/public/');

$app->bind('HomeController', function() use ($app) {
	return new App\Controllers\HomeController($app['view'], new App\Models\User);
});

require_once BASE_PATH . 'app/routes.php';

$app->run();


