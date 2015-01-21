<?php namespace Champion\Security\Authenticator;

interface IAuthenticator
{
    public function authenticate($username, $password);
}
