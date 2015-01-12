<?php namespace Champion;

use Champion\Exceptions\ConfigurationException;
use Nette\Neon\Neon;

class Configurator
{
    private $configuration = array();

    /**
     * @param $name
     * @param array $arguments
     * @return array|null
     * @throws ConfigurationException
     *
     * @SuppressWarnings("unused")
     */
    public function __call($name, array $arguments)
    {
        preg_match('/^get(.*)/i', $name, $matches);

        if (isset($matches) && !empty($matches[1])) {
            return $this->configuration[strtolower($matches[1])];
        }

        throw new ConfigurationException(sprintf('Method %s() does not exist.', $name));
    }

    /**
     * @param $file
     * @throws ConfigurationException
     */
    public function setConfiguration($file)
    {
        if (!is_file($file) || !is_readable($file)) {
            throw new ConfigurationException(sprintf("File %s not found or not readable.", $file));
        }

        $neon = new Neon();
        $this->configuration = $neon->decode(file_get_contents($file));
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
