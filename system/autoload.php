<?php

spl_autoload_register(function ($className) {
	$className = BASE_PATH . $className . '.php';

	if (file_exists($className)) {
		require $className;
	} else {
		throw new \Exception("Failed to autoload {$className}");
	}
});