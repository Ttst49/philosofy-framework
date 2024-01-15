<?php

namespace App\Controller;

use App\Repository\PizzaRepository;
use Core\Controller\Controller;
use Core\Http\Response;

class PizzaController extends Controller
{

    public function index():Response{

        $pizzas = new PizzaRepository();

        return $this->render("pizza/index",[
            "pizzas"=>$pizzas->findAll()
        ]);

    }

}