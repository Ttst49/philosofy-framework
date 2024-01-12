<?php

use Core\Kernel\Kernel;

require_once "../vendor/autoload.php";

/**
 * $router = new \Core\Route\Router();
 * $router->addRoute([
 * "route"=>"/pizza/create",
 * "c&m"=>[
 * PizzaController::class,
 * "create"
 * ]
 * ]);
 */

Kernel::run();


