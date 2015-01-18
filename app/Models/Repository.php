<?php namespace Monoblock\Models;

use Champion\Core\ServiceContainer;
use Doctrine\ODM\MongoDB\DocumentManager;

class Repository
{
    /** @var DocumentManager */
    protected $documentManager;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->documentManager = $serviceContainer->get('Doctrine\ODM\MongoDB\DocumentManager');
    }
}
