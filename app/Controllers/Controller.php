<?php namespace Monoblock\Controllers;

use Champion\Configuration\Configurator;
use Champion\Core\ServiceContainer;
use Champion\Exceptions\ServiceNotFoundException;
use Champion\Utils\Environment;
use Champion\Utils\Macros\MacroLoader;
use Champion\Utils\Redirector;
use Champion\Utils\Url;
use Doctrine\ODM\MongoDB\DocumentManager;
use Latte\Engine;
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

    /**
     * @var string
     */
    protected $action;

    /**
     * @var DocumentManager
     */
    protected $documentManager;

    public function __construct(ServiceContainer $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
        $this->documentManager = $this->serviceContainer->get('Doctrine\ODM\MongoDB\DocumentManager');

        try {
            $this->authenticator = $this->serviceContainer->get('Monoblock\Models\MongoAuthenticator');
        } catch (ServiceNotFoundException $e) {
            $this->authenticator = null;
        }
    }

    public function render($parameters = array())
    {
        $url = new Url;
        $latte = new Engine;

        $macroLoader = new MacroLoader($latte);
        $macroLoader->loadMacros();

        $parameters['layout'] = "../@layout.latte";
        $parameters['basePath'] = $url->getAppBaseUri();
        $parameters['config'] = $this->getConfigParams();
        $parameters['user'] = null;

        if ($this->authenticator->isAuthenticated()) {
            $parameters['user'] = $this->authenticator->getUser();
        }

        if (!Environment::isLocalEnvironment()) {
            $latte->setTempDirectory(__DIR__ . '/../../temp/');
        }

        $latte->render($this->getTemplateFile(get_called_class()), $parameters);
    }

    private function getAction()
    {
        $trace = debug_backtrace();
        return $trace[3]['function'];
    }

    private function getConfigParams()
    {
        $configurator = new Configurator();
        $configurator->setConfiguration(__DIR__ . '/../Configuration/template.params.neon');

        return $configurator->getConfiguration();
    }

    private function getTemplateFile($calledClass)
    {
        $parsedController = explode('\\', $calledClass);
        $folder = ucfirst(str_replace('Controller', '', end($parsedController)));

        return sprintf('%s/../Views/%s/%s.latte', __DIR__, $folder, $this->getAction());
    }
}
