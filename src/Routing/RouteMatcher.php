<?php namespace Champion\Routing;

use Champion\HttpRequest;
use Champion\Utils\Url;

class RouteMatcher
{
    /**
     * @param Route $route
     * @param Url $url
     * @param HttpRequest $httpRequest
     *
     * @return bool
     */
    public function match(Route $route, Url $url, HttpRequest $httpRequest)
    {
        if (
            $route->getHttpMethod() === $httpRequest->getMethod()
            && $route->getPath() === $url->getBasePath()
        ) {
            return true;
        }

        return false;
    }
}
