<?php namespace Monoblock\Controllers;

use Champion\Security\PasswordHelper;
use Champion\Utils\Url;
use Monoblock\Models\MongoAuthenticator;
use Monoblock\Models\UserRepository;
use Nette\Forms\Form;
use Nette\Utils\Html;

class SecurityController extends Controller
{
    /**
     * @var UserRepository
     * @inject Monoblock\Models\UserRepository
     */
    public $userRepository;

    public function index()
    {
        $href = Html::el('a', array('href' => 'register'))->setText('Register User');
        echo $href;
    }

    public function register()
    {
        $form = new Form();

        $form->addText('name', 'Name');
        $form->addText('email', 'Email');
        $form->addPassword('password', 'Password');

        $form->addSubmit('submit', 'Create');

        if ($form->isSuccess()) {
            $this->createuser($form->getValues());
        }

        echo $form;
    }

    public function createUser($values)
    {
        $this->userRepository->create($values->name, $values->email, $values->password);

        $this->redirect('/security/login');
    }

    public function loginUser()
    {
        if ($this->authenticator->isAuthenticated()) {
            $this->redirect('/admin');
        }

        $form = new Form();

        $form->addText('email', 'Email');
        $form->addPassword('password', 'Password');

        $form->addSubmit('submit', 'Login');

        if ($form->isSuccess()) {
            $this->tryToLogIn($form, $form->getValues());
        }

        echo $form;
    }

    private function tryToLogIn(Form $form, $values)
    {
        $authenticated = $this->authenticator->authenticate($values->email, $values->password);

        if ($authenticated) {
            $this->redirect('/admin');
        }

        $form->addError('Bad username or password');
        return $form;
    }

    public function logout()
    {
        $this->authenticator->logout();

        $this->redirect('/security/login');
    }
}
