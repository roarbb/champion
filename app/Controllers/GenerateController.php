<?php namespace Monoblock\Controllers;

use Monoblock\Documents\RecipeRepository;

class GenerateController extends Controller
{
    public function index()
    {
        /** @var RecipeRepository $recipeRepository */
        $recipeRepository = $this->documentManager->getRepository('Monoblock\Documents\Recipe');

        $randomRecipes = $recipeRepository->getRandomRecipes(7);

        $this->render(array('recipes' => $randomRecipes));
    }
}
