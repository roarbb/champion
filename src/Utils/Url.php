<?php namespace Champion\Utils;

class Url
{
    private $url;

    public function __construct()
    {
        $this->url = $this->getActualUrl();
    }

    /**
     * @return array
     */
    private function getActualUrl()
    {
        $server = $_SERVER;

        $ssl = (!empty($server['HTTPS']) && $server['HTTPS'] == 'on') ? true : false;

        $serverProtocol = strtolower($server['SERVER_PROTOCOL']);

        $protocol = substr($serverProtocol, 0, strpos($serverProtocol, '/')) . (($ssl) ? 's' : '');

        $port = $server['SERVER_PORT'];
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;

        $host = $server['SERVER_NAME'] . $port;

        $parsedUri = $this->parseUrl($server);

        $basePath = $this->calculateBasePath($server, $parsedUri);

        return array(
            'protocol' => $protocol,
            'host' => $host,
            'path' => $parsedUri['path'],
            'query' => $parsedUri['query'],
            'basePath' => $basePath,
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url['protocol'] . '://' . $this->url['host'] . $this->url['path']
        . ($this->url['query'] ? '?' . $this->url['query'] : '');
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        parse_str($this->url['query'], $query);
        return $query;
    }

    /**
     * @param array $query
     * @return $this
     */
    public function setNewQuery(array $query)
    {
        $this->url['query'] = http_build_query($query);
        return $this;
    }

    /**
     * @param $server
     * @return mixed
     */
    private function parseUrl($server)
    {
        $parsedUrl = parse_url($server['REQUEST_URI']);

        if (!isset($parsedUrl['query'])) {
            $parsedUrl['query'] = "";
        }

        return $parsedUrl;
    }

    private function calculateBasePath($server, array $parsedUri)
    {
        $scriptNameWithoutFilename = $this->cleanScriptName($server['SCRIPT_NAME']);

        $basePath = $parsedUri['path'];
        if($scriptNameWithoutFilename !== '/') {
            $basePath = str_replace($scriptNameWithoutFilename, '', $parsedUri['path']);
        }

        if (empty($basePath)) {
            return '/';
        }

        if($basePath === '/') {
            return $basePath;
        }

        // if last character is "/", return basePath without it
        if(substr($basePath, -1) === '/') {
            return substr($basePath, 0, -1);
        }

        return $basePath;
    }

    public function getBasePath()
    {
        return $this->url['basePath'];
    }

    private function cleanScriptName($scriptName)
    {
        $explodedName = explode('/', $scriptName);

        // script name = /champion/public/index.php
        // unset first empty part(/ in front)
        unset($explodedName[0]);
        // + unset filename part (index.php)
        unset($explodedName[count($explodedName)]);

        return '/' . implode('/', $explodedName);
    }

    public function getAppBaseUri()
    {
        $trimmedPath = rtrim($this->url['path'], '/');

        if ($this->url['basePath'] === '/') {
            return $trimmedPath;
        }

        return str_replace($this->url['basePath'], '', $trimmedPath);
    }
}
