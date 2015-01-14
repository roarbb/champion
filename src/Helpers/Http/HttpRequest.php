<?php namespace Champion\Helpers\Http;

class HttpRequest
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
