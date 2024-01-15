<?php

namespace Core\Route;

use Core\Controller\Controller;
use Core\Http\Request;
use ReflectionClass;
use Core\Attributes\Route;

class Router
{

    /**
     * @var Route[]
     */
    private array $routes;


      public function addRoute(array $routes){
      $this->routes[$routes["route"]] = $routes["c&m"];
      }


    /**
     * public function getRoutes():array{
     *
     * $reflection = new ReflectionClass(Controller::class);
     * var_dump($reflection);
     * $attributes = $reflection->getAttributes(Route::class);
     * $arguments = $attributes[0]->getArguments();
     * $uri = $arguments["uri"];
     * // recup toutes les classes du namespace controller
     * // foreach controller as controller
     * // pour chaque controlleur il faut recup les attributs
     * // voir dans le Abstract Repository
     * // ReflectionClass et getAttributes(Route::class)
     * // pour chaque attribut de classe route recup l'argument uri
     * // recup attributs routes de tous les controlleurs
     * // pour chaque attribut route créer un objet Route
     * // lui donner l'uri depuis l'attribut et lui donner le controlleur
     * // et la methode en cours d'iteration
     * // quand la route est créer la passer à addRoute
     *
     *
     * return [];
     * }
     */

    public function getControllerAndMethod(Request $request){

        $globals = $request->getGlobals();
        $uri = $globals["REQUEST_URI"];


        $controllerAndMethod= $this->getControllerAndMethodFromUri($uri);

        return $controllerAndMethod;
    }

    private function getControllerAndMethodFromUri(string $uri){
        foreach ($this->routes as $routeUri=>$controllerAndMethod){
            if ($routeUri === $uri){
                return $controllerAndMethod;
            }
        }
        return false;
    }

}