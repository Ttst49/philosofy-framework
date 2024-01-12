<?php

namespace App\Controller;

use Core\Http\Response;

class HomeController extends \Core\Controller\Controller
{

    public function index():Response
    {



        return $this->render("home/index", [
            "pageTitle"=> "Welcome to the framework"
        ]);
    }




}