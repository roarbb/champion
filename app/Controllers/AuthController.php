<?php namespace Monoblock\Controllers;

use Champion\Utils\Form\BootstrapRenderer;
use Monoblock\Forms\LoginForm;
use Monoblock\Models\UserRepository;
use Nette\Forms\Form;
use Nette\Utils\Html;

class AuthController extends Controller
{
    use BootstrapRenderer;

    public function login()
    {
        if ($this->authenticator->isAuthenticated()) {
            $this->redirect('/admin');
        }

        $form = new LoginForm();
        $this->render(array('loginForm' => $form->getForm($this->authenticator)));
    }

    public function logout()
    {
        $this->authenticator->logout();
        $this->redirect('/');
    }
}
