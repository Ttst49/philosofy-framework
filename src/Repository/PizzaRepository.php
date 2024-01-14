<?php

namespace App\Repository;

use App\Entity\Pizza;
use Core\Attributes\TargetEntity;
use Core\Repository\Repository;

#[TargetEntity(name: Pizza::class)]
class PizzaRepository extends Repository
{

    public function save(Pizza $pizza){

        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET name:name, description:description, degree:degree");

        $query->execute(
            [
                "name"=>$pizza->getName(),
                "description"=>$pizza->getDescription(),
                "price"=>$pizza->getPrice(),
            ]
        );
    }

    public function edit(Pizza $pizza){

        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET name:name, description:description, degree:degree WHERE id:id");

        $query->execute(
            [
                "id"=>$pizza->getId(),
                "name"=>$pizza->getName(),
                "description"=>$pizza->getDescription(),
                "price"=>$pizza->getPrice(),
            ]
        );
    }

}