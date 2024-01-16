<?php

namespace App\Controller;

use App\Entity\Pizza;
use Core\Attributes\Route;
use Core\Http\Request;
use Core\Http\Response;

class HomeController extends \Core\Controller\Controller
{

    #[Route(uri: "/home")]
    public function index():Response
    {


        // request on veut recup name et description et verifier
        // va chercher dans post ce qu'il te faut pour créer un objet pizza
        // si tout va bien tu crées l'objet pizza sinon tu renvoie null
        // $pizza = $request->resolveEntity(EntityClass);
        // if ($pizza){save}

        $request = new Request();
        $request->createObjectFromClassName(Pizza::class);


        return $this->render("home/index", [
            "pageTitle"=> "Welcome to the framework"
        ]);
    }

    #[Route(uri: "/home/show")]
    public function show():Response{



        return $this->render("home/show",[]);
    }




}