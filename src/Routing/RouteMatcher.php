<?php namespace Champion\Routing;

use Champion\Helpers\Http\HttpRequest;
use Champion\Utils\Url;

class RouteMatcher
{
    private $wildCardSign = '@';

    /**
     * @param Route $route
     * @param Url $url
     * @param HttpRequest $httpRequest
     *
     * @return bool
     */
    public function match(Route $route, Url $url, HttpRequest $httpRequest = null)
    {
        $routePath = $route->getPath();
        $actualPath = $url->getBasePath();

        if ($this->getPathPartsCount($routePath) !== $this->getPathPartsCount($actualPath)) {
            return false;
        }

        if (!$this->compatibleRequestMethod($route, $httpRequest)) {
            return false;
        }

        if ($this->pathsCompatible($routePath, $actualPath)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $path
     * @return int
     */
    private function getPathPartsCount($path)
    {
        return count(explode('/', $path));
    }

    /**
     * Determine if 2 strings are compatible paths
     *
     * @param $routePath
     * @param $actualPath
     * @return bool
     */
    public function pathsCompatible($routePath, $actualPath)
    {
        $routePathParts = explode('/', $routePath);
        $actualPathParts = explode('/', $actualPath);

        if ($this->getPathPartsCount($routePath) !== $this->getPathPartsCount($actualPath)) {
            return false;
        }

        foreach ($actualPathParts as $pathKey => $pathString) {
            if ($this->firstCharacterIsWildcard($routePathParts, $pathKey)
                || $this->partsAreIdentical($pathString, $routePathParts, $pathKey)
            ) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * @param $routePathParts
     * @param $key
     * @return bool
     */
    private function firstCharacterIsWildcard($routePathParts, $key)
    {
        if (!isset($routePathParts[$key]) || empty($routePathParts[$key])) {
            return false;
        }

        return substr($routePathParts[$key], 0, 1) === $this->getWildCardSign();
    }

    /**
     * @param $path
     * @param $routePathParts
     * @param $key
     * @return bool
     */
    private function partsAreIdentical($path, $routePathParts, $key)
    {
        return isset($routePathParts[$key]) && $path === $routePathParts[$key];
    }

    /**
     * @return string
     */
    public function getWildCardSign()
    {
        return $this->wildCardSign;
    }

    /**
     * @param Route $route
     * @param HttpRequest $httpRequest
     * @return bool
     */
    private function compatibleRequestMethod(Route $route, HttpRequest $httpRequest)
    {
        $allowedMethods = explode('|', $route->getHttpMethod());
        return in_array($httpRequest->getMethod(), $allowedMethods);
    }
}
