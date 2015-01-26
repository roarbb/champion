<?php namespace Monoblock\Forms;

use Champion\Utils\Form\BootstrapRenderer;
use Champion\Utils\Redirector;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Monoblock\Documents\RecipeRepository;
use Nette\Forms\Form;

class RecipeEditForm
{
    use BootstrapRenderer;
    use Redirector;

    /**
     * @var RecipeRepository
     */
    private $recipeRepository;

    public function getForm(DocumentRepository $recipeRepository)
    {
//        $units = array('kg', 'ml', 'qty', 'tea spoon');
        $mealTypes = array('main', 'dinner', 'breakfast', 'snack', 'desert');
        $this->recipeRepository = $recipeRepository;

        $form = new Form('recipe');

        $form->addText('name', 'Name')->setAttribute('autocomplete', 'off')->setRequired('Please fill recipe name.');
        $form->addText('tags', 'Tags')->setAttribute('placeholder', 'optional');
        $form->addTextArea('description', 'Description')->setAttribute('placeholder', 'optional');
        $form->addTextArea('instructions', 'Instructions')->setRequired('Instructions for recipe are missing.');

        $form->addSelect('mealType', 'Meal Type')->setItems($mealTypes, false);
        $form->addSubmit('submit', 'Create');

        if ($form->isSuccess()) {
            $this->createRecipe($form);
        }

        $this->setBootstrapRenderer($form);
        return $form;
    }

    public function createRecipe(Form $form)
    {
        try {
            $this->recipeRepository->create($form->getHttpData());
            $this->redirect('/admin/recipes');
        } catch (Exception $e) {
            $form->addError($e->getMessage());
            return $form;
        }
    }
}
