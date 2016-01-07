<?php

$app->get('/', 'App\Controllers\HomeController@index', 'home');

$app->get('/:name', 'App\Controllers\HomeController@index', 'home');

$app->get('/index', 'App\Controllers\HomeController@index', 'home');

$app->get('/home/index', 'App\Controllers\HomeController@index', 'home');

$app->get('/about/:name/:age', 'App\Controllers\HomeController@about', 'about');