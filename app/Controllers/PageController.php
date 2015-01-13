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
    }

    public function getPage($pageId)
    {
        echo "Showing page with ID: " . $pageId;
    }
}
