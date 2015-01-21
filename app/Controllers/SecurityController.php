<?php namespace Monoblock\Controllers;

use Champion\Security\PasswordHelper;
use Champion\Utils\Url;
use Monoblock\Models\UserRepository;
use Nette\Forms\Form;
use Nette\Utils\Html;

class SecurityController extends Controller
{
    /**
     * @var PasswordHelper
     * @inject Champion\Security\PasswordHelper
     */
    public $passwordHelper;

    /**
     * @var UserRepository
     * @inject Monoblock\Models\UserRepository
     */
    public $userRepository;

    public function index()
    {
        $url = new Url();
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

        $url = new Url();
        header("Location: " . $url);
        exit;
    }
}
