<?php namespace Champion;

use Champion\Routing\Route;

class ClassRunner
{
    public function run(Route $route)
    {
        call_user_func(
            array($route->getController(), $route->getControllerMethod())
        );
    }
}
