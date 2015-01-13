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
}
