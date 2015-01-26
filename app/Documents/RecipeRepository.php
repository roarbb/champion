<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\DocumentRepository;

class RecipeRepository extends DocumentRepository
{
    public function create($recipeData)
    {
        $recipe = new Recipe();

        $recipe->setName($recipeData['name']);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->setDescription($recipeData['description']);
        $recipe->setInstructions($recipeData['instructions']);
        $recipe->setMealType($recipeData['mealType']);

        if (!empty($recipeData['ingredients'])) {
            $this->addIngredients($recipe, $recipeData['ingredients']);
        }

        if (!empty($recipeData['tags'])) {
            $this->addTags($recipe, $recipeData['tags']);
        }

        $this->getDocumentManager()->persist($recipe);
        $this->getDocumentManager()->flush();

        return $recipe;
    }

    public function getAll()
    {
        return $this->createQueryBuilder()->getQuery()->execute();
    }

    public function getByIngredients(array $ingredientNames)
    {
        return $this->createQueryBuilder()
            ->field('ingredients.name')->in($ingredientNames)
            ->getQuery()->execute();
    }

    private function addIngredients(Recipe $recipe, $ingredients)
    {
        $nonEmptyIngredients = array_filter($ingredients, function($ingredient) {
            return !empty($ingredient['name']) && !empty($ingredient['amount']);
        });

        foreach ($nonEmptyIngredients as $ingredient) {
            $recipe->addIngredient(new Ingredient($ingredient['name'], $ingredient['unit'], $ingredient['amount']));
        }
    }

    private function addTags(Recipe $recipe, $tags)
    {
        $tagsArray = explode(',', $tags);

        foreach ($tagsArray as $tag) {
            $recipe->addTag(new Tags(trim($tag)));
        }
    }

    public function deleteRecipe($recipeId)
    {
        $recipe = $this->find($recipeId);
        $tags = $recipe->getTags();
        $ingredients = $recipe->getIngredients();

        foreach ($tags as $tag) {
            $this->createQueryBuilder()
                ->remove('Monoblock\Documents\Tags')
                ->field('_id')
                ->equals($tag->getTagId())
                ->getQuery()
                ->execute();
        }

        foreach ($ingredients as $ingredient) {
            $this->createQueryBuilder()
                ->remove('Monoblock\Documents\Ingredient')
                ->field('_id')
                ->equals($ingredient->getIngredientId())
                ->getQuery()
                ->execute();
        }

        $this->createQueryBuilder()->remove()
            ->field('_id')->equals($recipeId)
            ->getQuery()->execute();
    }
}
