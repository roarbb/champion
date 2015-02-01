<?php namespace Monoblock\Datagrids;

use Champion\Utils\Url;
use Datagrid\Datagrid;
use Doctrine\ODM\MongoDB\Cursor;
use Monoblock\Documents\Recipe;
use Nette\Utils\Html;

class RecipeListDatagrid
{
    /**
     * @var array
     */
    private $recipes;

    public function __construct(Cursor $recipes)
    {
        $this->recipes = $this->recipesToArray($recipes);
    }

    private function getDatagrid()
    {
        $url = new Url();
        $apiUri = $url->getAppBaseUri();

        $datagrid = new Datagrid();
        $datagrid->setData($this->recipes);

        $datagrid->setTableClass('table');
        $datagrid->hideColumns(array('id'));

        $datagrid->addHeader(array('Id', 'Name', 'Meal Type', 'Published'));

        $datagrid->addAction('Edit', $apiUri . '/admin/recipes/edit/{id}');
        $datagrid->addAction('Delete', $apiUri . '/admin/recipes/delete/{id}');

        return $datagrid;
    }

    public function __toString()
    {
        //<div class="alert alert-info" role="alert">...</div>
        if (empty($this->recipes)) {
            $emptyMessage = Html::el('div', array(
                'class' => 'alert alert-info',
                'role' => 'alert',
            ))->setHtml('Your <strong>Recipe Box</strong> is Empty.');

            return strval($emptyMessage);
        }

        return strval($this->getDatagrid());
    }

    private function recipesToArray($recipes)
    {
        $out = array();

        /** @var Recipe $recipe */
        foreach ($recipes as $recipe) {
            $row = array();
            $row['id'] = $recipe->getRecipeId();
            $row['name'] = $recipe->getName();
            $row['mealType'] = $recipe->getMealType();
            $row['published'] = intval($recipe->getPublished());

            $out[] = $row;
        }

        return $out;
    }
}
