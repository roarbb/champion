<?php namespace Champion\Helpers\Objects;

use Champion\Core\ServiceContainer;
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
     * @param Route $route
     * @param $serviceContainer
     * @throws RuntimeException
     */
    public function run(Route $route, ServiceContainer $serviceContainer)
    {
        $methodToRun = $this->classMethod;

        if (is_null($methodToRun)) {
            throw new RuntimeException("Can not execute object method. Method not provided.");
        }

        $controller = $this->getInstanceWithDependencies($serviceContainer);
        $this->runMethod($controller, $methodToRun, $route);
    }

    /**
     * @param ServiceContainer $serviceContainer
     * @return object
     * @throws RuntimeException
     */
    public function getInstanceWithDependencies(ServiceContainer $serviceContainer)
    {
        $constructParams = array();
        $parameters = $this->getConstructorParameters();

        foreach ($parameters as $className) {
            if ($className === get_class($serviceContainer)) {
                $constructParams[] = $serviceContainer;
                continue;
            }

            $class = new self($className);
            $constructParams[] = $class->getInstanceWithDependencies($serviceContainer);
        }

        return $this->reflection->newInstanceArgs($constructParams);
    }

    private function runMethod($controller, $methodToRun, Route $route)
    {
        $methodObject = new MethodObject($methodToRun, $controller);
        $methodObject->runMethodForPath($route);
    }
}
