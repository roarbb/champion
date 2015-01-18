<?php namespace Monoblock\Controllers;

use Monoblock\Models\UserRepository;

/**
 * Class UserController
 * @package Monoblock\Controllers
 */
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

        foreach ($users as $user) {
            \Tracy\Debugger::dump($user);
        }
    }

    public function createUser()
    {
        $name = 'Miloš';
        $this->userRepository->create($name, lcfirst($name) . '@gmail.com', new \Datetime());
        \Tracy\Debugger::dump('User ' . $name . ' Created.');
    }
}
