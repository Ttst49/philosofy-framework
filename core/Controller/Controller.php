<?php

namespace Core\Controller;

use Core\Http\Response;
use Core\View\View;

abstract class Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function redirect(string $route = null)
    {

        return $this->response->redirect($route);
    }
    public function render($nomDeTemplate, $donnees)
    {
        return $this->response->render($nomDeTemplate, $donnees);
    }

}