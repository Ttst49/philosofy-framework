<?php

namespace Core\Http;

class Request
{

    private array $globals;

    public function __construct(){
        $this->globals = $_SERVER;
    }

    public function getGlobals():array{
        return $this->globals;
    }

}