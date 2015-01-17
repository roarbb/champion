<?php namespace Monoblock;

use Champion\Routing\Route;
use Champion\Routing\Router;

class Routes
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();

        $this->router->setEndpoint(
            new Route('GET', '/', '\Monoblock\Controllers\HomeController')
        );

        $this->router->setEndpoint(
            new Route('GET', '/page/@id', '\Monoblock\Controllers\PageController', 'getPage')
        );

        $this->router->setEndpoint(
            new Route('GET', '/page', '\Monoblock\Controllers\PageController', 'showAllPages')
        );

        $this->router->setEndpoint(
            new Route('POST', '/page', '\Monoblock\Controllers\PageController', 'createPage')
        );

        $userEndpoints = array(
            new Route('GET', '/user', '\Monoblock\Controllers\UserController'),
            new Route('GET', '/user/create', '\Monoblock\Controllers\UserController', 'createUser'),
        );

        $this->router->setEndpoints($userEndpoints);
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}
