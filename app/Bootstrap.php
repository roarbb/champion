<?php

use Champion\Configuration\Configurator;
use Champion\Core\Application;
use Champion\Core\ServiceContainer;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Monoblock\Routes;
use Tracy\Debugger;

include_once(__DIR__ . '/../vendor/autoload.php');
Debugger::enable();
Debugger::$maxDepth = 10;

/** @var $application */
$application = new Application();

$configurator = new Configurator();
$configurator->setConfiguration(__DIR__ . '/../app/Configuration/config.neon');

$serviceContainer = new ServiceContainer();
$serviceContainer->addService($configurator);

$routes = new Routes();
$router = $routes->getRouter();

$application->setRouter($router);


// ---------------- MongoDB Start ---------------------------
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
// ---------------- MongoDB End -----------------------------

$application->setServiceContainer($serviceContainer);

return $application;
