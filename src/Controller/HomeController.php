<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController {
/**
 * @Route("/hello/{prenom}",name="hello")
 * 
 * @return void
 */

public function hello($prenom="anonyme"){

    return new Response("bonjours......".$prenom);
}




/**
 * 
 * @Route("/",name="homepage")
 */

    public function home(){

return $this->render('home.html.twig');

    }




}




?>