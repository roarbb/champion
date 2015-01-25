<?php namespace Monoblock\Forms;

use Champion\Utils\Form\BootstrapRenderer;
use Champion\Utils\Redirector;
use Monoblock\Models\MongoAuthenticator;
use Nette\Forms\Form;

class LoginForm
{
    use BootstrapRenderer;
    use Redirector;

    /**
     * @var MongoAuthenticator
     */
    private $authenticator;

    public function getForm(MongoAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;

        $form = new Form('form-signin');

        $form->addText('email', 'Email')
            ->setType('email')
            ->addRule(Form::EMAIL)
            ->setAttribute('placeholder', 'e-mail address')
            ->setRequired('Please, fill in your e-mail address');

        $form->addPassword('password', 'Password')
            ->setRequired('Please set Password');

        $form->addSubmit('submit', 'Login');

        if ($form->isSuccess()) {
            $this->tryToLogIn($form, $form->getValues());
        }

        $this->setBootstrapRenderer($form);

        return $form;
    }

    private function tryToLogIn(Form $form, $values)
    {
        $authenticated = $this->authenticator->authenticate($values->email, $values->password);

        if ($authenticated) {
            $this->redirect('/admin');
        }

        $form->addError('Bad Username or Password');
        return $form;
    }
}
