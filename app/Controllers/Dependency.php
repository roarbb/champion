<?php namespace Monoblock\Controllers;

class Dependency
{
    /**
     * @var DependencyAnother
     */
    private $depka2;

    public function __construct(DependencyAnother $depka2)
    {
        $this->depka2 = $depka2;
    }
}
