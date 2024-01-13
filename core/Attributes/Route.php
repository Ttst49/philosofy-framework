<?php

namespace Core\Attributes;

use Attribute;

#[Attribute]
class Route
{
    private string $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }
}