<?php

namespace App\Repository;

use App\Entity\Pizza;
use Core\Attributes\TargetEntity;
use Core\Repository\Repository;

#[TargetEntity(name: Pizza::class)]
class PizzaRepository extends Repository
{

    //pizza get_class($pizza)=>pizza::class
    //reflection = on recup les props qui portent l'attribut column
    //$props = ["name","desc",...]
    public function save(Pizza $pizza){

        $sql = "INSERT INTO $this->tableName";

        foreach ($props as $prop){
            $sql.+"$prop=:$prop";
        }

        $tableauExecute = [];
        foreach ($props as $prop){
            $getter = "get".ucfirst($prop);
            $tableauExecute[$prop] = $object->$getter();
        }

        $query = $this->pdo->prepare($sql);

        $query->execute(
            [
                "name"=>$pizza->getName(),
                "description"=>$pizza->getDescription(),
                "price"=>$pizza->getPrice(),
            ]
        );
    }

    public function edit(Pizza $pizza){

        $query = $this->pdo->prepare("UPDATE $this->tableName SET name:name, description:description, degree:degree WHERE id:id");

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