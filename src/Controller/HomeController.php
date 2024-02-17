<?php

namespace App\Controller;

use Core\Attributes\Route;
use Core\Controller\Controller;
use Core\Http\Response;
use Core\HttpClient\HttpClient;

class HomeController extends Controller
{
    #[Route(uri: "/", name: "app_home_index", methods: ["GET"])]
    public function index():Response
    {
        $client = new HttpClient('https://jsonplaceholder.typicode.com');

        $response = $client->get('/posts');
        //$response = $client->post('/posts');
        //$response = $client->put('/posts/1');
        //$response = $client->patch('/posts/1');
        //$response = $client->delete('/posts/1');

        return $this->json($response);

        //  return $this->render("home/index", [
        //            "pageTitle"=> "Welcome to /home",
        //            "data"=>$response
        //        ]);
    }

    #[Route(uri: "/home/show/{id}", name: "app_home_show", methods: ["GET", "POST"])]
    public function show(int $id):Response
    {
        //echo($id);
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home/show"
        ]);
    }

    #[Route(uri: "/home/testQuack", name: "app_home_test", methods: ["GET", "POST"])]
    public function showQuack():Response
    {
        //echo($id);
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home/show",
            "name"=>"Jack",
            "fruits"=>["banane","poire","pomme"]
        ]);
    }
}