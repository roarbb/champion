<?php namespace Champion\Core;

class ServiceContainer
{
    private $services = array();

    public function addService($service)
    {
        $this->services[get_class($service)] = $service;
    }

    /**
     * @param $className
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function get($className)
    {
        if (isset($this->services[$className])) {
            return $this->services[$className];
        }

        throw new ServiceNotFoundException(sprintf('Service "%s" not found in %s', $className, __CLASS__));
    }

    public function getList()
    {
        return array_keys($this->services);
    }
}
