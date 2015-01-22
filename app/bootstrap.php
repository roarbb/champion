<?php

use Champion\Configuration\Configurator;
use Champion\Core\Application;
use Champion\Core\ServiceContainer;
use Champion\Routing\Router;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Monoblock\Models\MongoAuthenticator;
use Monoblock\Routes;
use Tracy\Debugger;

include_once(__DIR__ . '/../vendor/autoload.php');
Debugger::enable();
Debugger::$maxDepth = 10;

// ######### Basic Objects ##################
$application = new Application();
$serviceContainer = new ServiceContainer();
$application->setServiceContainer($serviceContainer);

// ######### Configurator ##################
$configurator = new Configurator();
$configurator->setConfiguration(__DIR__ . '/../app/Configuration/config.neon');
$serviceContainer->addService($configurator);

// ######### Routing ##################
$router = new Router();
$routes = new Routes($router);
$routes->setRoutes();
$application->setRouter($router);

// ######### Mongo Doctrine Setup ##################
$connection = new Connection();
$config = new Configuration();

$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/Hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('monoblock');

$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/../app/Documents'));

AnnotationDriver::registerAnnotationClasses();
$documentManager = DocumentManager::create($connection, $config);

$serviceContainer->addService($documentManager);

// ######### Authenticator ##################
$authenticator = new MongoAuthenticator($documentManager);
$serviceContainer->addService($authenticator);
$application->setAuthenticator($authenticator);

// ######### Return Initialized AppObject ##################
return $application;
