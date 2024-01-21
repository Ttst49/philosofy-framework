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

        return $this->renderQuack("home/index",$data=["pageTitle"=>"Je suis le titre","name"=>"jean pigeon"]);


        /**
         * return $this->render("home/index", [
         * "pageTitle"=> "Welcome to the framework"
         * ]);
         */
    }

    #[Route(uri: "/home/show")]
    public function show():Response{



        return $this->render("home/show",[]);
    }




}