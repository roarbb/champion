<?php namespace Monoblock\Controllers\Admin;

use Monoblock\Controllers\Controller;
use Monoblock\Datagrids\UserListDatagrid;
use Monoblock\Forms\UserEditForm;
use Monoblock\Models\UserRepository;

class UserController extends Controller
{
    /**
     * @var UserRepository
     * @inject Monoblock\Models\UserRepository
     */
    public $userRepository;

    public function index()
    {
        $users = $this->userRepository->getAll();
        $datagrid = new UserListDatagrid($users);

        $this->render(array('datagrid' => $datagrid));
    }

    public function add()
    {
        $form = new UserEditForm();
        $this->render(array('registerForm' => $form->getForm($this->userRepository)));
    }

    public function delete($userId)
    {
        $this->userRepository->deleteUser($userId);
        $this->redirect('/admin/user/');
    }

    public function edit($userId)
    {
        \Tracy\Debugger::dump('edyting user ' . $userId);
    }
}
