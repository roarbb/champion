<?php namespace Monoblock\Documents;

use Doctrine\ODM\MongoDB\DocumentRepository;

class RecipeRepository extends DocumentRepository
{
    public function create($recipeData)
    {
        $recipe = new Recipe();

        if (isset($recipeData['id']) && !empty($recipeData['id'])) {
            $recipe->setRecipeId($recipeData['id']);
        }

        $recipe->setName($recipeData['name']);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->setDescription($recipeData['description']);
        $recipe->setInstructions($recipeData['instructions']);
        $recipe->setMealType($recipeData['mealType']);
        $recipe->setTags($recipeData['tags']);

        if (!empty($recipeData['ingredients'])) {
            $this->addIngredients($recipe, $recipeData['ingredients']);
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
        $parsedIngredients = $this->parseIngredients($ingredients);

        $nonEmptyIngredients = array_filter($parsedIngredients, function($ingredient) {
            return !empty($ingredient['name']) && !empty($ingredient['amount']);
        });

        foreach ($nonEmptyIngredients as $ingredient) {
            $recipe->addIngredient(new Ingredient($ingredient['name'], $ingredient['unit'], $ingredient['amount'], $ingredient['id']));
        }
    }

    public function deleteRecipe($recipeId)
    {
        $recipe = $this->find($recipeId);
        $tags = $recipe->getTags();
        $ingredients = $recipe->getIngredients();

        $this->deleteTags($tags);
        $this->deleteIngredients($ingredients);

        $this->createQueryBuilder()->remove()
            ->field('_id')->equals($recipeId)
            ->getQuery()->execute();
    }

    private function parseIngredients($ingredients)
    {
        $out = array();

        foreach ($ingredients as $ingredientLabel => $ingredientData) {
            $dividedLabel = explode('_', $ingredientLabel);
            $out[$dividedLabel[0]][$dividedLabel[1]] = $ingredientData;
        }

        return $out;
    }

    private function deleteIngredients($ingredients)
    {
        foreach ($ingredients as $ingredient) {
            $this->createQueryBuilder()
                ->remove('Monoblock\Documents\Ingredient')
                ->field('_id')
                ->equals($ingredient->getIngredientId())
                ->getQuery()
                ->execute();
        }
    }

    private function deleteTags($tags)
    {
        foreach ($tags as $tag) {
            $this->createQueryBuilder()
                ->remove('Monoblock\Documents\Tag')
                ->field('_id')
                ->equals($tag->getTagId())
                ->getQuery()
                ->execute();
        }
    }
}
