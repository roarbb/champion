<?php namespace Champion;

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
}
