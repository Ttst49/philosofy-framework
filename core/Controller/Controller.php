<?php

namespace Core\Controller;

use Core\Http\Response;
use Core\Session\Flash;
use Core\Session\Session;
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
    public function oldRender($nomDeTemplate, $donnees)
    {
        return $this->response->oldRender($nomDeTemplate, $donnees);
    }

    public function render(string $viewName, $data): Response
    {
        return $this->response->render($viewName, $data);
    }

    public function json($toSerialize){
        return $this->response->json($toSerialize);
    }

    public function addFlash(string $message, string $color = "primary")
    {
        Flash::addMessage($message, $color);
    }

    public function getUser(): object | bool
    {
        if(Session::userConnected())
        {
            $userRepository = new UserRepository();
            return  $userRepository->find(Session::user()['id']);
        }
        return false;

    }

}