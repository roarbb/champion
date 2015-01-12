<?php namespace Champion;

use Champion\Utils\Url;

class Router
{
    private $endPoints = array();

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

    public function match()
    {
        array_map(
            array($this, 'checkEndpoint'),
            $this->getEndpoints()
        );
    }

    private function checkEndpoint(Route $route)
    {
        $url = new Url;
        $actualPath = $url->getBasePath();

        \Tracy\Debugger::dump($route);
        \Tracy\Debugger::dump($actualPath);
    }
}
