<?php namespace Monoblock\Controllers;

use Monoblock\Documents\User;

class AdminController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = $this->authenticator->getUser();

        $this->render(array('user' => $user));
    }
}
