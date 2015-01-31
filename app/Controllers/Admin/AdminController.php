<?php namespace Monoblock\Controllers\Admin;

use Monoblock\Controllers\Controller;
use Monoblock\Documents\User;
use Monoblock\Documents\UserRepository;

class AdminController extends Controller
{
    public function index()
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->documentManager->getRepository('Monoblock\Documents\User');
        $usersCount = $userRepository->getAll()->count();

        /** @var RecipeRepository $recipeRepository */
        $recipeRepository = $this->documentManager->getRepository('Monoblock\Documents\Recipe');
        $recipesCount = $recipeRepository->getAll()->count();

        $templateParams = array(
            'usersCount' => $usersCount,
            'recipesCount' => $recipesCount,
        );

        $this->render($templateParams);
    }
}
