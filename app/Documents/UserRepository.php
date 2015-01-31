<?php namespace Monoblock\Documents;

use Champion\Security\PasswordHelper;
use Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository
{
    public function create($name, $email, $password)
    {
        $user = new User();
        $passwordHelper = new PasswordHelper();

        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($passwordHelper->createHash($password));
        $user->setCreatedAt(new \DateTime());

        $this->getDocumentManager()->persist($user);
        $this->getDocumentManager()->flush();

        return $user;
    }

    public function getAll()
    {
        return $this->createQueryBuilder()->getQuery()->execute();
    }

    public function deleteUser($userId)
    {
        $this->createQueryBuilder()->remove()
            ->field('_id')->equals($userId)
            ->getQuery()->execute();
    }
}
