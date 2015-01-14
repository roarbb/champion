<?php namespace Champion;

use Champion\Routing\Router;

class Application
{
    public function start(Router $router)
    {
        $router->match();
    }
}
