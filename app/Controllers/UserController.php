<?php namespace Monoblock\Controllers;

use Champion\Core\ServiceContainer;
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
        $this->render(array('users' => $users));
    }
}
