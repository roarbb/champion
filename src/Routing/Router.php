<?php namespace Champion\Routing;

use Champion\HttpRequest;
use Champion\Utils\Url;

class Router
{
    private $endPoints = array();

    private $routeMatched = false;

    public function setEndpoint(Route $route)
    {
        $this->endPoints[] = $route;
    }

    /**
     * @return array
     */
    public function getEndPoints()
    {
        return $this->endPoints;
    }

    public function match()
    {
        array_map(
            array($this, 'checkEndpoint'),
            $this->getEndpoints()
        );

        if (!$this->routeMatched) {
            echo "404";
        }

    }

    /**
     * @param Route $route
     *
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    private function checkEndpoint(Route $route)
    {
        $url = new Url;
        $httpRequest = new HttpRequest;
        $routeMatcher = new RouteMatcher;

        $routeMatched = $routeMatcher->match($route, $url, $httpRequest);

        if ($routeMatched) {
            $this->routeMatched = true;

            $classRunner = new RouteRunner;
            $classRunner->run($route);
        }
    }
}
