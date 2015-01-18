<?php namespace Monoblock\Models;

use Monoblock\Documents\User;

class UserRepository extends Repository
{
    public function create($name, $email, $createdAt)
    {
        $user = new User();

        $user->setName($name);
        $user->setEmail($email);
        $user->setCreatedAt($createdAt);

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
