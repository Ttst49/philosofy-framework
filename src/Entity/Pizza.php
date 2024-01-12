<?php

namespace App\Entity;


use App\Repository\PizzaRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetRepository;

#[TargetRepository(name: PizzaRepository::class)]
#[Table(name:"pizzas" )]
class Pizza
{

    private $id;


}