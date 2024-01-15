<?php

namespace App\Entity;


use App\Repository\PizzaRepository;
use Core\Attributes\Column;
use Core\Attributes\Id;
use Core\Attributes\Table;
use Core\Attributes\TargetRepository;

#[TargetRepository(name: PizzaRepository::class)]
#[Table(name:"pizzas" )]
class Pizza
{

    #[Id()]
    private int $id;

    #[Column(name:"name")]
    private string $name;

    #[Column(name:"description")]
    private string $description;

    #[Column(name:"price")]
    private int $price;

    /**
     * #[ManyToOne(invertedBy: Comment::class)]
     * private array $comments;
     *
     *
     * public function getComments(){
     * $classname = get_class($this);
     * $method= "findBy".$classname;
     * return findByPizza($this);
     * }
     *
     * #[ForeignKey(className: Pizza::class)]
     * private int $pizza_id;
     */



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