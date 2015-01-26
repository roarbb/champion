<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Tags
{
    /** @ODM\Id */
    private $tagId;

    /** @ODM\String */
    private $name;

    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTagId()
    {
        return $this->tagId;
    }
}
