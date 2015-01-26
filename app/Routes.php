<?php namespace Monoblock;

use Champion\Routing\Route;
use Champion\Routing\Router;
use Champion\Routing\SecureRoute;

class Routes
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function setRoutes()
    {
        $endpoints = array();

        $endpoints[] = new Route('GET', '/', '\Monoblock\Controllers\HomeController');
        $endpoints[] = new Route('GET|POST', '/auth/login', '\Monoblock\Controllers\AuthController', 'login');
        $endpoints[] = new Route('GET', '/auth/logout', '\Monoblock\Controllers\AuthController', 'logout');

        $endpoints[] = new SecureRoute('GET', '/admin', '\Monoblock\Controllers\Admin\AdminController');
        $endpoints[] = new SecureRoute('GET', '/admin/user', '\Monoblock\Controllers\Admin\UserController');
        $endpoints[] = new SecureRoute('GET|POST', '/admin/user/add', '\Monoblock\Controllers\Admin\UserController', 'add');
        $endpoints[] = new SecureRoute('GET', '/admin/user/delete/@id', '\Monoblock\Controllers\Admin\UserController', 'delete');
        $endpoints[] = new SecureRoute('GET', '/admin/user/edit/@id', '\Monoblock\Controllers\Admin\UserController', 'edit');

        $endpoints[] = new SecureRoute('GET', '/admin/recipes', '\Monoblock\Controllers\Admin\RecipesController');
        $endpoints[] = new SecureRoute('GET|POST', '/admin/recipes/add', '\Monoblock\Controllers\Admin\RecipesController', 'add');
        $endpoints[] = new SecureRoute('GET', '/admin/recipes/delete/@id', '\Monoblock\Controllers\Admin\RecipesController', 'delete');

        $this->router->setEndpoints($endpoints);

        //todo: $this->router->setCrudEndpoint('/user');
    }
}
