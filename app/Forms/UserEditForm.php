<?php namespace Monoblock\Forms;

use Champion\Utils\Form\BootstrapRenderer;
use Champion\Utils\Redirector;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Documents\UserRepository;
use Nette\Forms\Form;

class UserEditForm
{
    use BootstrapRenderer;
    use Redirector;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function getForm(DocumentRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        $form = new Form();

        $form->addText('name', 'Name');
        $form->addText('email', 'Email');
        $form->addPassword('password', 'Password');

        $form->addSubmit('submit', 'Create');

        if ($form->isSuccess()) {
            $this->createuser($form->getValues());
        }

        $this->setBootstrapRenderer($form);
        return $form;
    }

    public function createUser($values)
    {
        $this->userRepository->create($values->name, $values->email, $values->password);
        $this->redirect('/admin/user');
    }
}
