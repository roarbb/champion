<?php namespace Champion\Core;

use Champion\Exceptions\RuntimeException;
use Champion\Routing\Router;
use Champion\Security\IAuthenticator;

class Application
{
    private $serviceContainer;

    /** @var Router */
    private $router;

    /** @var IAuthenticator */
    private $authenticator;

    /**
     * @throws RuntimeException
     */
    public function start()
    {
        session_start();

        if (is_null($this->serviceContainer)) {
            $this->serviceContainer = new ServiceContainer();
        }

        if (is_null($this->router)) {
            throw new RuntimeException('Please set up first Router for Application.');
        }

        if ($this->authenticator) {
            $this->router->setAuthenticator($this->authenticator);
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

    public function setAuthenticator(IAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }
}
