<?php namespace Champion\Helpers\Objects;

use Champion\Exceptions\RuntimeException;
use Champion\Routing\Route;

class ClassObject
{
    /** @var string */
    private $className;

    /** @var \ReflectionClass */
    private $reflection;

    /** @var string */
    private $classMethod;

    /**
     * @param string $controllerName
     * @param string $controllerMethod
     */
    public function __construct($controllerName, $controllerMethod = null)
    {
        $this->className = $controllerName;
        $this->reflection = new \ReflectionClass($controllerName);
        $this->classMethod = $controllerMethod;
    }

    /**
     * @return \ReflectionMethod
     */
    private function getConstructor()
    {
        return $this->reflection->getConstructor();
    }

    /**
     * @return array
     * @throws RuntimeException
     */
    private function getConstructorParameters()
    {
        if (!$this->getConstructor()) {
            return array();
        }

        $out = array();
        $parameters = $this->getConstructor()->getParameters();

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $parameterClass = $parameter->getClass();

            if (is_null($parameterClass)) {
                throw new RuntimeException(sprintf("Class can not be constructed. Constructor parameter $%s not specified.", $parameter->getName()));
            }

            $out[] = $parameterClass->getName();
        }

        return $out;
    }

    /**
     *
     *
     * @param Route $route
     * @throws RuntimeException
     */
    public function run(Route $route)
    {
        $methodToRun = $this->classMethod;

        if (is_null($methodToRun)) {
            throw new RuntimeException("Can not execute object method. Method not provided.");
        }

        $controller = $this->getInstanceWithDependencies();
        $this->runMethod($controller, $methodToRun, $route);
    }

    /**
     * @return object
     */
    public function getInstanceWithDependencies()
    {
        $constructParams = array();
        $parameters = $this->getConstructorParameters();

        foreach ($parameters as $className) {
            $class = new self($className);
            $constructParams[] = $class->getInstanceWithDependencies();
        }

        return $this->reflection->newInstanceArgs($constructParams);
    }

    private function runMethod($controller, $methodToRun, Route $route)
    {
        $methodObject = new MethodObject($methodToRun, $controller);
        $methodObject->runMethodForPath($route);
    }
}
