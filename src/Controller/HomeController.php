<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Repository\PizzaRepository;
use Core\Attributes\Route;
use Core\Http\Request;
use Core\Http\Response;
use Core\View\View;
use Exception;
use ReflectionException;

class HomeController extends \Core\Controller\Controller
{

    #[Route(uri: "/home")]
    public function index():Response
    {

        return $this->render("home/index", $data=
            ["title"=>"Je suis le titre","name"=>"tibo","fruits"=>["banane","poire","abricot"]]
        );


        /**
         * return $this->oldRender("home/index", [
         * "pageTitle"=> "Welcome to the framework"
         * ]);
         */
    }

    #[Route(uri: "/home/show")]
    public function show():Response{



        return $this->render("home/show",[]);
    }




}