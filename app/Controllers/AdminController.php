<?php namespace Monoblock\Controllers;

use Monoblock\Documents\User;

class AdminController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = $this->authenticator->getUser();

        \Tracy\Debugger::dump('Yay, Admin! Welcome ' . $user->getName());
    }
}
