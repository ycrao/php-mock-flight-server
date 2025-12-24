<?php

use app\controllers\admin\AuthController;
use app\controllers\admin\ArticleController;
use app\middlewares\SecurityHeadersMiddleware;
use app\middlewares\AdminUserAuthMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->render('welcome', [
            'message' => 'Welcome to the FlightPHP mock server!',
        ]);
	});

    /*
	$router->get('/hello-world/@name', function($name) {
		echo '<h1>Hello world! Oh hey '.$name.'!</h1>';
	});

	$router->group('/api', function() use ($router) {
		$router->get('/users', [ ApiExampleController::class, 'getUsers' ]);
		$router->get('/users/@id:[0-9]', [ ApiExampleController::class, 'getUser' ]);
		$router->post('/users/@id:[0-9]', [ ApiExampleController::class, 'updateUser' ]);
	});
    */
	
}, [ SecurityHeadersMiddleware::class ]);

// Admin API routes
$router->group('/admin-api', function(Router $router) use ($app) {

    $router->group('/auth', function(Router $router) use ($app) {
        $router->post('/login', [AuthController::class, 'postLogin']);
    });

    $router->group('/content', function(Router $router) use ($app) {
        $router->group('/article', function (Router $router) use ($app) {
            $router->get('/', [ArticleController::class, 'index']);
        });
    }, [ AdminUserAuthMiddleware::class ]);

});