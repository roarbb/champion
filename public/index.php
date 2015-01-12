<?php

use Champion\Configurator;
use Champion\Route;
use Champion\Router;
use Tracy\Debugger;

include_once(__DIR__ . '/../vendor/autoload.php');
Debugger::enable();

$configurator = new Configurator();
$configurator->setConfiguration(__DIR__ . '/../src/Configuration/config.neon');

$router = new Router();

$router->setEndpoint(new Route('GET', '/', 'HomeController'));
$router->setEndpoint(new Route('GET', '/page', 'PageController', 'showAllPages'));
$router->setEndpoint(new Route('GET', '/page', 'PageController', 'showAllPages'));
$router->setEndpoint(new Route('POST', '/page', 'PageController', 'createPage'));
