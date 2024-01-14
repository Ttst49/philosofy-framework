<?php

namespace App\Entity;


use App\Repository\PizzaRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetRepository;

#[TargetRepository(name: PizzaRepository::class)]
#[Table(name:"pizzas" )]
class Pizza
{

    private int $id;
    private string $name;
    private string $description;
    private int $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }


}