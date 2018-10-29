<?php

session_start();

// Require libraries
require 'vendor/autoload.php';
require 'config/routes.php';

// Autoload classes
spl_autoload_register(function($class) {
        
    if(substr($class, -10) === 'Controller') {
        $controller = 'controller/'.$class.'.php';
    }

    if(substr($class, -5) === 'Model') {
        $model = 'model/'.$class.'.php';
    }

    if(isset($controller) && file_exists($controller)) {
        require $controller;
    }

    if(isset($model) && file_exists($model)) {
        require $model;
    }
});

$router = new AltoRouter();
$router->setBasePath('');
$router->addRoutes($routes);

// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}