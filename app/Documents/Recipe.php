<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="RecipeRepository")
 */
class Recipe
{
    /** @ODM\Id */
    private $recipeId;

    /** @ODM\String */
    private $name;

    /** @ODM\Date */
    private $createdAt;

    /** @ODM\EmbedMany(targetDocument="Ingredient", strategy="set") */
    private $ingredients = array();

    /** @ODM\String */
    private $tags;

    /**
     * Breakfast/Main/Snack/Dinner
     * @ODM\String
     */
    private $mealType;

    /** @ODM\String */
    private $description;

    /** @ODM\String */
    private $instructions;

    /** @ODM\Int */
    private $servings;

    /** @ODM\Boolean */
    private $published;

    /**
     * @return mixed
     */
    public function getRecipeId()
    {
        return $this->recipeId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param mixed $ingredient
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;
    }

    /**
     * @return mixed
     */
    public function getMealType()
    {
        return $this->mealType;
    }

    /**
     * @param mixed $mealType
     */
    public function setMealType($mealType)
    {
        $this->mealType = $mealType;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return mixed
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * @param mixed $instructions
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
    }

    /**
     * @return integer
     */
    public function getServings()
    {
        return $this->servings;
    }

    /**
     * @param integer $servings
     */
    public function setServings($servings)
    {
        $this->servings = $servings;
    }

    /**
     * @param mixed $recipeId
     */
    public function setRecipeId($recipeId)
    {
        $this->recipeId = $recipeId;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }
}
