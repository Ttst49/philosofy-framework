<?php

namespace Core\Http;

use Core\Debugging\Debugger;
use Core\Serializer\Serializer;
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

    public function renderError($nomDeTemplate)
    {
        View::renderError($nomDeTemplate);
        return $this;
    }

    public function setHeaders(): void
    {
        $yaml = yaml_parse_file("../config/cors.yaml")["headers"];
        header('Access-Control-Allow-Origin: '.implode(", ", $yaml["Allow-Origin"]));
        header('Access-Control-Allow-Methods: '.implode(", ", $yaml["Allow-Methods"]));
        header("Content-Type".implode(", ", $yaml["Content-Type"]));
        header("Accept-Charset".implode(", ", $yaml["Accept-Charset"]));
        header("Access-Control-Max-Age".$yaml["Max-Age"]);
    }
    protected function setHttpResponseCode($code): void
    {
        http_response_code($code);
    }

    public function json($toSerialize)
    {
        Debugger::$profileBarStatus = false;
        $this->setHeaders();
        echo Serializer::serialize($toSerialize);
        return $this;
    }

}