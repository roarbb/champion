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
        $this->router->setEndpoints(
            array(
                new Route('GET', '/', '\Monoblock\Controllers\HomeController'),
                new Route('GET', '/user', '\Monoblock\Controllers\UserController'),
            )
        );

        $this->router->setEndpoints(
            array(
                new Route('GET', '/page/@id', '\Monoblock\Controllers\PageController', 'getPage'),
                new Route('GET', '/page', '\Monoblock\Controllers\PageController', 'showAllPages'),
                new Route('POST', '/page', '\Monoblock\Controllers\PageController', 'createPage'),
            )
        );

        $this->router->setEndpoint(
            new SecureRoute('GET', '/admin', '\Monoblock\Controllers\AdminController')
        );

        $securityEndpoints = array(
            new Route('GET', '/security', '\Monoblock\Controllers\SecurityController'),

            new Route('GET', '/security/register', '\Monoblock\Controllers\SecurityController', 'register'),
            new Route('POST', '/security/register', '\Monoblock\Controllers\SecurityController', 'register'),

            new Route('GET', '/security/login', '\Monoblock\Controllers\SecurityController', 'loginUser'),
            new Route('POST', '/security/login', '\Monoblock\Controllers\SecurityController', 'loginUser'),

            new Route('GET', '/security/logout', '\Monoblock\Controllers\SecurityController', 'logout'),
        );
        $this->router->setEndpoints($securityEndpoints);

        //todo: $this->router->setCrudEndpoint('/user');
    }
}
