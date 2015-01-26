<?php namespace Monoblock\Controllers\Admin;

use Monoblock\Controllers\Controller;
use Monoblock\Datagrids\RecipeListDatagrid;
use Monoblock\Documents\RecipeRepository;
use Monoblock\Forms\RecipeEditForm;

class RecipesController extends Controller
{
    public function index()
    {
        /** @var RecipeRepository $recipe */
        $recipe = $this->documentManager->getRepository('Monoblock\Documents\Recipe');

        $datagrid = new RecipeListDatagrid($recipe->getAll());

        $this->render(array('datagrid' => $datagrid));
    }

    public function add()
    {
        $form = new RecipeEditForm();
        $recipeRepository = $this->documentManager->getRepository('Monoblock\Documents\Recipe');
        $this->render(array('form' => $form->getForm($recipeRepository)));
    }

    public function delete($recipeId)
    {
        /** @var RecipeRepository $recipe */
        $recipe = $this->documentManager->getRepository('Monoblock\Documents\Recipe');
        $recipe->deleteRecipe($recipeId);

        $this->redirect('/admin/recipes/');
    }
}
