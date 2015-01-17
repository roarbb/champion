<?php namespace Champion\Core;

class ServiceContainer
{
    private $services = array();

    public function addService($service)
    {
        $this->services[get_class($service)] = $service;
    }

    public function get($className)
    {
        if (isset($this->services[$className])) {
            return $this->services[$className];
        }

        return null;
    }

    public function getList()
    {
        return array_keys($this->services);
    }
}
