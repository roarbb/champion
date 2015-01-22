<?php namespace Monoblock\Models;

use Champion\Security\IAuthenticator;
use Champion\Security\PasswordHelper;
use Champion\Utils\Redirector;
use Doctrine\ODM\MongoDB\DocumentManager;
use Monoblock\Documents\User;

class MongoAuthenticator implements IAuthenticator
{
    use Redirector;

    private $documentManager;
    private $userSessionKey = 'mongo-user';

    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * Try to authenticate user.
     * If user found in DB set user to $_SESSION and return true.
     *
     * If user not found in DB or password is incorrect return false;
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function authenticate($email, $password)
    {
        $passwordHelper = new PasswordHelper();

        /** @var User $user */
        $user = $this->documentManager
            ->getRepository('\Monoblock\Documents\User')
            ->findOneBy(
                array('email' => $email)
            );

        if ($passwordHelper->validatePassword($password, $user->getPassword())) {
            $_SESSION[$this->userSessionKey] = $user;
            return true;
        }

        return false;
    }

    /**
     * Determines if user is logged in.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if (isset($_SESSION[$this->userSessionKey]) && !empty($_SESSION[$this->userSessionKey])) {
            return true;
        }

        return false;
    }

    /**
     * Returns logged User Document or null.
     *
     * @return null|User
     */
    public function getUser()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        return $_SESSION[$this->userSessionKey];
    }

    /**
     * Redirects to login page.
     */
    public function redirectToLogin()
    {
        $this->redirect('/security/login');
    }

    /**
     * Logouts user.
     */
    public function logout()
    {
        unset($_SESSION[$this->userSessionKey]);
    }
}
