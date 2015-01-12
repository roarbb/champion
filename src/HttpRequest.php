<?php namespace Champion;

class HttpRequest
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
