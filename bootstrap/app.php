<?php

$app = new System\Application();

// if the framework files and folders are within a folder in your local server, in my case, mvc.
// you have to set the base path.
$app->getInstance('router')->setBasePath('mvc/public/');

require_once BASE_PATH . 'app/routes.php';

$app->run();
