<?php namespace Champion\Routing;

use Champion\Core\ServiceContainer;
use Champion\Helpers\Objects\ClassObject;

class RouteRunner
{
    public function run(Route $route, ServiceContainer $serviceContainer)
    {
        $controller = new ClassObject($route->getController(), $route->getControllerMethod());
        $controller->run($route, $serviceContainer);
    }
}
