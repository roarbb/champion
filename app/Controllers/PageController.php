<?php namespace Monoblock\Controllers;

class PageController
{
    private $dependency;

    public function __construct(Dependency $dependency)
    {
        $this->dependency = $dependency;
    }

    public function showAllPages()
    {
        echo __CLASS__;
        echo "<br />";
        echo __METHOD__;

        echo "<form method='post'>";
        echo "<input type='submit' value='call post request - PageController::createPage()'>";
        echo "<input type='hidden' name='test' value='value' />";
        echo "</form>";
    }

    public function getPage($pageId)
    {
        echo "Showing page with ID: " . $pageId;
    }

    public function createPage()
    {
        \Tracy\Debugger::dump($_POST);
    }
}
