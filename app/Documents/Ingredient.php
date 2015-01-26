<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Ingredient
{
    /** @ODM\Id */
    private $ingredientId;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $unit;

    /** @ODM\Float */
    private $amount;

    public function __construct($name, $unit, $amount)
    {
        if (empty($name) || empty($amount) || empty($unit)) {
            throw new \InvalidArgumentException('Name or amount or unit of Ingredient empty.');
        }

        $this->setName($name);
        $this->setUnit($unit);
        $this->setAmount($amount);
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
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getIngredientId()
    {
        return $this->ingredientId;
    }
}
