<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $paramView = [
            'theme' => 'darktly',
            'loggedin' => true,
            'nextEvent' => null,
            'commuFlow' => null,
        ];
        if(isset($_SESSION["user"])){
            $paramView['loggedin'] = true;
        }
        return $this->render('home/index.html.twig', $paramView);
    }
}
