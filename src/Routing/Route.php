<?php namespace Champion\Routing;

use Champion\Utils\Url;

class Route
{
    /**
     * @var string
     */
    private $httpMethod;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $controllerMethod;

    public function __construct($httpMethod, $path, $controller, $controllerMethod = 'default')
    {
        $this->httpMethod = $httpMethod;
        $this->path = $path;
        $this->controller = $controller;
        $this->controllerMethod = $controllerMethod;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getControllerMethod()
    {
        return $this->controllerMethod;
    }

    public function getWildCardArguments()
    {
        $url = new Url();
        $actualPath = $url->getBasePath();
        $routeMatcher = new RouteMatcher();
        $out = array();

        $actualPathParts = explode('/', $actualPath);
        $routePathParts = explode('/', $this->getPath());

        foreach ($actualPathParts as $pathKey => $pathValue) {
            if (
                !isset($routePathParts[$pathKey])
                || substr($routePathParts[$pathKey], 0, 1) !== $routeMatcher->getWildCardSign()
            ) {
                continue;
            }

            $out[] = $pathValue;
        }

        return $out;
    }
}
