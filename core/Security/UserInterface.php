<?php

namespace Core\Security;

interface UserInterface
{



    public function getId();
    public function getAuthenticator();
    public function getPassword();

}