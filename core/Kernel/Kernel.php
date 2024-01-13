<?php

namespace Core\Kernel;

use Core\Environment\DotEnv;
use Core\Http\Request;
use Core\Http\Response;
use Core\Route\Router;

class Kernel
{

    public static function run()
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        if($environment === "dev"){
            \Core\Debugging\Debugger::run();
        }

        $router = new Router();
        $router->getRoutes();

    $type = "home";
    $action = "index";

    if(!empty($_GET['type'])){ $type = $_GET['type']; }
    if(!empty($_GET['action'])){ $action = $_GET['action']; }



    $type = ucfirst($type);
    $controllerName = "App\Controller\\".$type."Controller";

    $controller = new $controllerName();

    $controller->$action();



    }


    public static function handleRequest():Response{
        $request = new Request();
        /**
         * foreach ($request->getGlobals() as $key=>$global) {
         * echo "<p><strong>$key</strong>: $global</p>";
         * }
         */
        $router = new Router();
        $controllerAndMethod = $router->getControllerAndMethod($request);
        $controller = new $controllerAndMethod["controller"]();
        return $controller->$controllerAndMethod["method"]();
    }

}