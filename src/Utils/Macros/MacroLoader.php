<?php namespace Champion\Utils\Macros;

use Champion\Routing\RouteMatcher;
use Champion\Utils\Url;
use Latte\Engine;
use Latte\MacroNode;
use Latte\Macros\MacroSet;

class MacroLoader
{
    /**
     * @var Engine
     */
    private $latte;

    public function __construct(Engine $latte)
    {
        $this->latte = $latte;
    }

    public function loadMacros()
    {
        $set = new MacroSet($this->latte->getCompiler());

        $this->loadIfCurrent($set);
    }

    private function loadIfCurrent($set)
    {
        $url = new Url();
        $routeMatcher = new RouteMatcher();

        $set->addMacro('ifCurrent', function(MacroNode $node, $writer) use ($routeMatcher, $url) {
            $args = $node->args;

            if (empty($args)) {
                $args = '/';
            }

            $compatiblePaths = $routeMatcher->pathsCompatible($args, $url->getBasePath());
            return $writer->write('if ("' . $compatiblePaths . '"):');
        }, 'endif');
    }
}
