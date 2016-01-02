<?php

$app->get('/', 'HomeController@index', 'home');

$app->get('/about', 'HomeController@about', 'about');