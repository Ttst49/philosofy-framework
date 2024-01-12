<?php

namespace Core\Attributes;

use Attribute;

#[Attribute]
class Route
{
    private string $uri;

    public function __contruct(string $uri){
        $this->uri = $uri;
    }
}