<?php namespace Champion;

class Router
{
    private $endPoints = array();

    public function setEndpoint(Route $route)
    {
        $this->endPoints[] = $route;
    }

    public function match()
    {
        echo "Class: " . __CLASS__ . "<br />Process: Matching...";
    }
}
