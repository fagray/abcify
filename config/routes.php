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

$router = new RouteCollector();

$router->get('/', function(){

    return print 'Home Page';
});


$router->get('/posts', ['App\Controllers\PostsController','index'] );
$router->get('/posts/create', ['App\Controllers\PostsController','create'] );
$router->post('/posts/create', ['App\Controllers\PostsController','store'] );


$dispatcher =  new Dispatcher($router->getData());

$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));


?>