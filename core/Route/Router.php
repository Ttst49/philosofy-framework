<?php

namespace Core\Route;

use App\Controller\HomeController;
use Core\Http\Request;

class Router
{

    /**
     * @var Route[]
     */
    private array $routes;


      public function addRoute(array $routes){
      $this->routes[$routes["route"]] = $routes["c&m"];
      }


    public function getRoutes():array{
        // recup toutes les classes dy namespace controller
        // foreach controller as controller
        // pour chaque controlleur il faut recup les attributs
        // voir dans le Abstract Repository
        // ReflectionClass et getAttributes(Route::class)
        // pour chaque attribut de classe route recup l'argument uri
        // recup attributs routes de tous les controlleurs
        // pour chaque attribut route créer un objet Route
        // lui donner l'uri depuis l'attribut et lui donner le controlleur
        // et la methode en cours d'iteration
        // quand la route est créer la passer à addRoute



        }

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
    }

}