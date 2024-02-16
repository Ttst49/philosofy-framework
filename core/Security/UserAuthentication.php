<?php

namespace Core\Security;

use Core\Session\Session;

abstract class UserAuthentication implements UserInterface
{

    protected int $id;
    protected string $username;
    protected string $password;

    public function encryptPassword(string $clearPassword):string
    {
        return password_hash($clearPassword, PASSWORD_DEFAULT);
    }

    public function passwordMatches(string $clearPassword):bool
    {
        return password_verify($clearPassword,$this->password);

    }

    public function setPassword($clearPassword)
    {
        $this->password = $this->encryptPassword($clearPassword);
    }

    public function logIn(string $clearPassword)
    {
        if($this->passwordMatches($clearPassword))
        {
            Session::set("user",[
                "id"=>$this->getId(),
                "authenticator"=>$this->getAuthenticator()
            ]);

            return true;
        }
        return false;


    }

    public function logOut()
    {
        Session::remove("user");
    }

}