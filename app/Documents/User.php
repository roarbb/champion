<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="UserRepository")
 */
class User
{
    /** @ODM\Id */
    private $userId;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $email;

    /** @ODM\String */
    private $password;

    /** @ODM\Date */
    private $createdAt;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setPassword($hash)
    {
        $this->password = $hash;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
