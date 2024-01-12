<?php

namespace Core\Kernel;

use Core\Environment\DotEnv;

class Kernel
{

    public static function run()
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        if($environment === "dev"){
            \Core\Debugging\Debugger::run();
        }


    $type = "home";
    $action = "index";

    if(!empty($_GET['type'])){ $type = $_GET['type']; }
    if(!empty($_GET['action'])){ $action = $_GET['action']; }



    $type = ucfirst($type);
    $controllerName = "App\Controller\\".$type."Controller";

    $controller = new $controllerName();

    $controller->$action();



    }

}