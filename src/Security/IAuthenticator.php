<?php namespace Champion\Security;

interface IAuthenticator
{
    public function authenticate($email, $password);
    public function isAuthenticated();
    public function getUser();
    public function redirectToLogin();
    public function logout();
}
