<?php

namespace Core\Route;


use Core\Http\Request;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes;

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $controllerDirectory = __DIR__ . '/../../src/Controller';

        $controllerFiles = scandir($controllerDirectory);
        $controllerFiles = array_filter($controllerFiles, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });

        $controllerClasses = array_map(function ($file) {
            return '\\App\\Controller\\' . pathinfo($file, PATHINFO_FILENAME);
        }, $controllerFiles);

        $this->routes = $this->getRoutes($controllerClasses);
    }

    /**
     * @param array $controllers
     * @return array|Route[]|mixed
     * @throws \ReflectionException
     */
    public function getRoutes(array $controllers)
    {
        foreach ($controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);
            $methodsInController = $reflectionController->getMethods();

            $parentClass = $reflectionController->getParentClass();
            $methodsInAbstractController = $parentClass ? $parentClass->getMethods() : [];

            $methodsOnlyInControllerOnly = array_udiff(
                $methodsInController,
                $methodsInAbstractController,
                function ($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                }
            );

            foreach ($methodsOnlyInControllerOnly as $method) {

                $attributes = $method->getAttributes(\Core\Attributes\Route::class);

                foreach ($attributes as $attribute) {
                    $argument = $attribute->getArguments();
                    $route = new Route();
                    $route->setUri($argument['uri']);
                    $route->setName($argument['name']);
                    $route->setMethods(array_map('strtoupper', $argument['methods']));
                    $route->setController($controller);
                    $route->setMethod($method->getName());

                    $this->addRoute($route);
                }
            }
        }
        return $this->routes;
    }

    /**
     * @param $route
     * @return void
     */
    public function addRoute($route)
    {
        $this->routes[] = $route;
        //$this->routes[$route['route']] = $route['c&m'];
    }

    /**
     * @param Request $request
     * @return Route|mixed|null
     */
    public function getControllerAndMethod(Request $request)
    {
        $globals = $request->getGlobals();
        $uri = $globals['REQUEST_URI'];

        return $this->getControllerAndMethodFromUri($uri);
    }

    /**
     * @param string $uri
     * @return Route|mixed|null
     */
    private function getControllerAndMethodFromUri(string $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = $this->buildRoutePattern($route->getUri());

            if (preg_match($pattern, $uri, $matches)) {
                $route->setUriData(array_slice($matches, 1));

                return $route;
            }
        }
        return null;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function buildRoutePattern(string $uri): string
    {
        $pattern = preg_replace('/{(\w+)}/', '(\w+)', $uri);

        return '/^' . str_replace('/', '\/', $pattern) . '$/';
    }
}