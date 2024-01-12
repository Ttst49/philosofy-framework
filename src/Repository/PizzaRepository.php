<?php

namespace App\Repository;

use App\Entity\Pizza;
use Core\Attributes\TargetEntity;

#[TargetEntity(name: Pizza::class)]
class PizzaRepository
{

}