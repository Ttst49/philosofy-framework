<?php

namespace Core\Http;

use Core\View\View;

class Response
{

    public function render($nomDeTemplate, $donnees)
    {
         View::render($nomDeTemplate, $donnees);
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

    public function json():Response{
        //TODO: faire ça
        echo "coucou";
        return $this;
    }

}