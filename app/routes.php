<?php

$app->get('/', 'HomeController@index', 'home');

$app->get('/about', 'HomeController@about', 'about');

$app->get('/contact', function() {
  echo "You can contact me at pocsanjr@gmail.com";
}, "contact");
