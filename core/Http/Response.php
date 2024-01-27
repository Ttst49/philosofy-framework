<?php

namespace Core\Http;

use Core\View\View;

class Response
{

    public function oldRender($nomDeTemplate, $donnees)
    {
         View::oldRender($nomDeTemplate, $donnees);
         return $this;
    }


    public function redirect(string $route = null)
    {
        if(!$route){
            header("Location: index.php");
            exit;
        }else{
            header("Location: $route");
        }
        return $this;

    }

    public function render($viewName, $data):Response{
        View::render($viewName,$data);
        return $this;
    }

    public function json():Response{
        //TODO: faire ça
        echo "coucou";
        return $this;
    }

    public function renderError($nomDeTemplate)
    {
        View::renderError($nomDeTemplate);
        return $this;
    }

}