<?php namespace Monoblock\Controllers;

use Monoblock\Models\UserRepository;

class UserController
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();

        foreach ($users as $user) {
            \Tracy\Debugger::dump($user);
        }
    }

    public function createUser()
    {
        $name = 'Marek';
        $this->userRepository->create($name, $name . '@gmail.com', new \Datetime());
        \Tracy\Debugger::dump('User ' . $name . ' Created.');
    }
}
