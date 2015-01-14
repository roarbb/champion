<?php namespace Champion\Helpers\Objects;

use Champion\Routing\Route;

class MethodObject
{
    /**
     * @var string
     */
    private $method;

    /** @var object */
    private $class;

    public function __construct($method, $class)
    {
        $this->method = $method;
        $this->class = $class;
    }
    
    public function runMethodForPath(Route $route)
    {
        $methodReflection = new \ReflectionMethod($this->class, $this->method);
        $methodReflection->invokeArgs($this->class, $route->getWildCardArguments());
    }
}
