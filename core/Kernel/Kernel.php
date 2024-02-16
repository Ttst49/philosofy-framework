<?php

namespace Core\Kernel;

use App\Controller\HomeController;
use App\Entity\Pizza;
use Core\Debugging\Debugger;
use Core\Environment\DotEnv;
use Core\Http\Request;
use Core\Http\Response;
use Core\Route\Router;
use Core\ServiceContainer\ServiceContainer;
use Core\Session\Session;

class Kernel
{

    public static function run() : Response
    {
        $debugger = new Debugger();
        $debugger->run();

        Session::start();


        $request = new Request;
        $router = new Router();

        $serviceContainer = new ServiceContainer();


        $controllerAndMethod = $router->getControllerAndMethod($request);
        //echo '<pre>';
        //        print_r($controllerAndMethod);
        //        echo '</pre>';

        $globals = $request->getGlobals();
        //echo '<pre>';
        //        print_r($globals);
        //        echo '</pre>';



        // if (!in_array($globals['REQUEST_METHOD'],$controllerAndMethod->getMethods())){
        //      // throw new \Exception('Invalid request method. You are using the '.$globals['REQUEST_METHOD'].' method, but the expected method for this operation is');
        // }

        //print_r($controllerAndMethod->getMethods());

        foreach ($controllerAndMethod->getMethods() as $method) {
            if ($method === $globals['REQUEST_METHOD']) {
                $controllerName = $controllerAndMethod->getController();
                $controller = new $controllerName();

                $method = $controllerAndMethod->getMethod();
                $uriData= $controllerAndMethod->getUriData();

                //$dependencies = $serviceContainer->resolveMethod($controller, $method);
                //$arguments = array_merge($dependencies, []);

                return $controller->$method(...$uriData);
                //call_user_func_array([$controller, $method], $arguments);
            }
        }

        throw new \Exception('Invalid request method. You are using the '.$globals['REQUEST_METHOD'].' method, but the expected method for this operation is');
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