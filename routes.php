<?php


/**
* 
*-----------------------------------------------------------------------
*
* Application Routes
* 
*-----------------------------------------------------------------------
*
**/

use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\Dispatcher;
use Rayms\View\View;

$router = new RouteCollector();

$router->get('/', ['App\Controllers\HomeController','index'] );
$router->get('/login', ['App\Controllers\AuthController','login'] );
$router->post('/login', ['App\Controllers\AuthController','authenticate'] );
$router->get('/logout', ['App\Controllers\AuthController','logout'] );

$router->get('/api/products', ['App\Controllers\ProductsController','index'] );
$router->post('/api/products/{id}/rate', ['App\Controllers\ProductsController','rate'] );
$router->post('/api/cart/start-shopping', ['App\Controllers\CartController','startShopping'] );
$router->get('/api/cart', ['App\Controllers\CartController','index'] );
$router->post('/api/cart/checkout', ['App\Controllers\CartController','checkout'] );
$router->delete('/api/cart/list/{list_index}/remove', ['App\Controllers\CartController','removeProduct']);
$router->post('/api/cart/list/{list_index}/update-qty', ['App\Controllers\CartController','updateProductQty']);

$router->get('/api/wallet/balance', ['App\Controllers\WalletsController','getBalance'] );

$router->get('/cart/view', ['App\Controllers\CartController','show'] );
$router->get('/transactions', ['App\Controllers\TransactionsController','index'] );


$dispatcher =  new Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


?>