<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Core\Attributes\Table;
use Core\Attributes\TargetRepository;
use Core\Security\UserAuthentication;

#[TargetRepository(name: UserRepository::class)]
#[Table(name:"users")]
class User extends UserAuthentication
{
    protected int $id;
    protected string $username;
    protected string $password;
    private string $roles = "";

    public function getRoles()
    {

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    public function getAuthenticator()
    {
        return $this->username;
    }
}