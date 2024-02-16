<?php

namespace App\Repository;

use App\Entity\User;
use Core\Attributes\TargetEntity;

#[TargetEntity(name: User::class)]
class UserRepository extends \Core\Repository\Repository
{

    public function findByUsername(string $username)
    {
        $query = $this->pdo->prepare("SELECT * FROM $this->tableName WHERE username = :username");

        $query->execute(["username"=>$username]);

        $query->setFetchMode(\PDO::FETCH_CLASS,get_class(new $this->targetEntity()));

        $item = $query->fetch();

        return $item;
    }

    public function save(User $user):object
    {

        $query = $this->pdo->prepare("INSERT INTO $this->tableName SET username = :username, password = :password");
        $query->execute([
            "username"=>$user->getUsername(),
            "password"=>$user->getPassword()
        ]);

        return $this->find($this->pdo->lastInsertId());

    }
}