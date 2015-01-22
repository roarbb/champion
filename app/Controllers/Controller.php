<?php namespace Monoblock\Controllers;

use Champion\Core\ServiceContainer;
use Champion\Exceptions\ServiceNotFoundException;
use Champion\Utils\Redirector;
use Monoblock\Models\MongoAuthenticator;

class Controller
{
    use Redirector;

    /**
     * @var ServiceContainer
     */
    public $serviceContainer;

    /**
     * @var MongoAuthenticator
     */
    public $authenticator;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;

        try {
            $this->authenticator = $this->serviceContainer->get('Monoblock\Models\MongoAuthenticator');
        } catch (ServiceNotFoundException $e) {
            $this->authenticator = null;
        }
    }
}
