<?php namespace Monoblock\Forms;

use Champion\Utils\Form\BootstrapRenderer;
use Champion\Utils\Redirector;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Monoblock\Documents\Ingredient;
use Monoblock\Documents\Recipe;
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

    private $recipeId;

    public function getForm(DocumentRepository $recipeRepository, $recipeId = null)
    {
        $form = new Form('recipe');
        $this->recipeId = $recipeId;
        $this->recipeRepository = $recipeRepository;

        if ($this->recipeId) {
            /** @var Recipe $recipe */
            $recipe = $this->recipeRepository->find($this->recipeId);

            $form->addHidden('id', $recipe->getRecipeId());
        }

        $units = array('kg', 'ml', 'qty', 'tea spoon');
        $mealTypes = array('main', 'dinner', 'breakfast', 'snack', 'desert');

        $form->addText('name', 'Name')->setAttribute('autocomplete', 'off')->setRequired('Please fill recipe name.');
        $form->addText('tags', 'Tags')->setAttribute('placeholder', 'optional');
        $form->addTextArea('description', 'Description')->setAttribute('placeholder', 'optional');
        $form->addTextArea('instructions', 'Instructions')->setRequired('Instructions for recipe are missing.');
        $form->addSelect('mealType', 'Meal Type')->setItems($mealTypes, false);

        $ingredients = $form->addContainer('ingredients');

        for ($i=0;$i<20;$i++) {
            $ingredients->addText($i .'_name', 'Ingredient');
            $ingredients->addText($i . '_amount', 'Amount');
            $ingredients->addSelect($i . '_unit', 'Unit')->setItems($units, false);
            $ingredients->addHidden($i . '_id');
        }

        $form->addCheckbox('published', 'Published');
        $form->addSubmit('submit', 'Create');

        if ($form->isSuccess()) {
            $this->createRecipe($form);
        }

        if (isset($recipe)) {
            $this->setFormDefaults($form, $recipe);
        }

        $this->setBootstrapRenderer($form);
        return $form;
    }

    public function createRecipe(Form $form)
    {
        try {
            $this->recipeRepository->create($form->getValues());
            $this->redirect('/admin/recipes');
        } catch (Exception $e) {
            $form->addError($e->getMessage());
            return $form;
        }
    }

    private function setFormDefaults($form,Recipe $recipe)
    {
        $form['name']->setDefaultValue($recipe->getName());
        $form['description']->setDefaultValue($recipe->getDescription());
        $form['mealType']->setDefaultValue($recipe->getMealType());
        $form['tags']->setDefaultValue($recipe->getTags());
        $form['instructions']->setDefaultValue($recipe->getInstructions());
        $form['published']->setDefaultValue($recipe->getPublished());

        /**
         * @var int $ingredientNumber
         * @var Ingredient $ingredient
         */
        foreach ($recipe->getIngredients() as $ingredientNumber => $ingredient) {
            $form['ingredients'][$ingredientNumber . '_name']->setDefaultValue($ingredient->getName());
            $form['ingredients'][$ingredientNumber . '_unit']->setDefaultValue($ingredient->getUnit());
            $form['ingredients'][$ingredientNumber . '_amount']->setDefaultValue($ingredient->getAmount());
            $form['ingredients'][$ingredientNumber . '_id']->setDefaultValue($ingredient->getIngredientId());
        }
    }
}
