<?php

spl_autoload_register(function($className) {
	$className = BASE_PATH . strtolower($className) . '.php';

	if (file_exists($className)) {
		require $className;
	} else {
		throw new \Exception("Unable to autoload [{$className}]");
	}
});