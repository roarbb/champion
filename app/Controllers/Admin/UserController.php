<?php namespace Monoblock\Controllers\Admin;

use Monoblock\Controllers\Controller;
use Monoblock\Datagrids\UserListDatagrid;
use Monoblock\Forms\UserEditForm;

class UserController extends Controller
{
    public function index()
    {
        $users = $this->documentManager->getRepository('Monoblock\Documents\User')->getAll();

        $datagrid = new UserListDatagrid($users);

        $this->render(array('datagrid' => $datagrid));
    }

    public function add()
    {
        $form = new UserEditForm();
        $userRepository = $this->documentManager->getRepository('Monoblock\Documents\User');
        $this->render(array('registerForm' => $form->getForm($userRepository)));
    }

    public function delete($userId)
    {
        $this->documentManager->getRepository('Monoblock\Documents\User')->deleteUser($userId);
        $this->redirect('/admin/user/');
    }

    public function edit($userId)
    {
        \Tracy\Debugger::dump('edyting user ' . $userId);
    }
}
