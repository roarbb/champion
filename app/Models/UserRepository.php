<?php namespace Monoblock\Models;

use Champion\Security\PasswordHelper;
use Monoblock\Documents\User;

class UserRepository extends Repository
{
    public function create($name, $email, $password)
    {
        $user = new User();
        $passwordHelper = new PasswordHelper();

        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($passwordHelper->createHash($password));
        $user->setCreatedAt(new \DateTime());

        $this->documentManager->persist($user);
        $this->documentManager->flush();
    }

    public function getAll()
    {
        $queryBuilder = $this->documentManager->createQueryBuilder('Monoblock\Documents\User');
        $query = $queryBuilder->getQuery();

        return $query->execute();
    }
}
