<?php namespace Champion\Routing;

use Champion\Helpers\Objects\ClassObject;

class RouteRunner
{
    public function run(Route $route)
    {
        $controller = new ClassObject($route->getController(), $route->getControllerMethod());
        $controller->run($route);
    }
}
