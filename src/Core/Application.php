<?php namespace Champion\Core;

use Champion\Exceptions\RuntimeException;
use Champion\Routing\Router;

class Application
{
    private $serviceContainer;
    private $router;

    /**
     * @throws RuntimeException
     */
    public function start()
    {
        if (is_null($this->serviceContainer)) {
            $this->serviceContainer = new ServiceContainer();
        }

        if (is_null($this->router)) {
            throw new RuntimeException('Please set up first Router for Application.');
        }

        $this->router->match($this->serviceContainer);
    }

    /**
     * @param Router $router
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param ServiceContainer $serviceContainer
     */
    public function setServiceContainer(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }
}
