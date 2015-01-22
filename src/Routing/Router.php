<?php namespace Champion\Routing;

use Champion\Core\ServiceContainer;
use Champion\Helpers\Http\HttpRequest;
use Champion\Security\IAuthenticator;
use Champion\Utils\Url;

class Router
{
    private $endPoints = array();

    private $routeMatched = false;

    /**
     * @var ServiceContainer
     */
    private $serviceContainer;

    /**
     * @var IAuthenticator
     */
    private $authenticator;

    /**
     * @param Route $route
     */
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

    /**
     * @param ServiceContainer $serviceContainer
     */
    public function match(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;

        array_map(
            array($this, 'checkEndpoint'),
            $this->getEndpoints()
        );

        if (!$this->routeMatched) {
            echo "404";
        }

    }

    /**
     * @param array $endpoints
     */
    public function setEndpoints(array $endpoints)
    {
        foreach ($endpoints as $endpoint) {
            $this->endPoints[] = $endpoint;
        }
    }

    /**
     * @param IAuthenticator $authenticator
     */
    public function setAuthenticator(IAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
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

            if ($route->isGuarded() && !$this->authenticator->isAuthenticated()) {
                $this->authenticator->redirectToLogin();
            }

            $classRunner = new RouteRunner;
            $classRunner->run($route, $this->serviceContainer);
        }
    }
}
