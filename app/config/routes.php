<?php

use app\controllers\admin\AuthController;
use app\controllers\admin\ArticleController;
use app\controllers\admin\CategoryController;
use app\controllers\admin\UserController;
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

    // user module micro-service routes
    $router->group('/ms-user', function  (Router $router) use ($app) {

        $router->post('/auth/login', [AuthController::class, 'postLogin']);

        $router->group('/user', function (Router $router) use ($app) {
            $router->get('/', [UserController::class, 'index']);
            // current user info
            $router->get('/me', [UserController::class, 'me']);
            // Create a new user
            $router->post('/', [UserController::class, 'store']);
            // Show a user by id
            $router->get('/@id:[1-9]', [UserController::class, 'show']);
            // Update a user by id (using put or post method)
            $router->put('/@id:[1-9]', [UserController::class, 'update']);
            $router->post('/@id:[1-9]', [UserController::class, 'update']);

            // Delete a user by id
            $router->delete('/@id:[1-9]', [UserController::class, 'destroy']);
        }, [ AdminUserAuthMiddleware::class ]);

    });

    // content module micro-service routes
    $router->group('/ms-content', function(Router $router) use ($app) {

        $router->group('/article', function (Router $router) use ($app) {
            $router->get('/', [ArticleController::class, 'index']);
            // Create a new article
            $router->post('/', [ArticleController::class, 'store']);
            // Show an article by id
            $router->get('/@id:[0-9]{1,3}', [ArticleController::class, 'show']);
            // Update an article by id (using put or post method)
            $router->put('/@id:[0-9]{1,3}', [ArticleController::class, 'update']);
            $router->post('/@id:[0-9]{1,3}', [ArticleController::class, 'update']);

            // Delete an article by id
            $router->delete('/@id:[0-9]', [ArticleController::class, 'destroy']);
        });

        $router->group('/category', function (Router $router) use ($app) {
            $router->get('/all', [CategoryController::class, 'all']);
            // Create a new category
            $router->post('/', [CategoryController::class, 'store']);
            // Show a category by id
            $router->get('/@id:[1-9]', [CategoryController::class, 'show']);
            // Update a category by id (using put or post method)
            $router->put('/@id:[1-9]', [CategoryController::class, 'update']);
            $router->post('/@id:[1-9]', [CategoryController::class, 'update']);

            // Delete an article by id
            $router->delete('/@id:[0-9]', [CategoryController::class, 'destroy']);
        });

    }, [ AdminUserAuthMiddleware::class ]);

});