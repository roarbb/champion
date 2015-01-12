<?php

use Champion\Application;
use Champion\Configurator;
use Champion\Routing\Route;
use Champion\Routing\Router;
use Tracy\Debugger;

include_once(__DIR__ . '/../vendor/autoload.php');
Debugger::enable();

$app = new Application();

$configurator = new Configurator();
$configurator->setConfiguration(__DIR__ . '/../src/Configuration/config.neon');

$router = new Router();
$router->setEndpoint(new Route('GET', '/', 'HomeController'));
$router->setEndpoint(new Route('GET', '/page', '\\Monoblock\\Controllers\\PageController', 'showAllPages'));
$router->setEndpoint(new Route('POST', '/page', 'PageController', 'createPage'));

$app->start($router);
