<?php namespace Champion\Routing;

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
}
