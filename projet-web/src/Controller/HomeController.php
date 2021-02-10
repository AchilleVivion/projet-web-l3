<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="root")
     */
    public function root(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{_locale}/", name="home")
     */
    public function index(): Response
    {
        if(false){
            $theme = 'flatly';
            $nav_theme = 'navbar-light';
        }
        else{
            $theme = 'darktly';
            $nav_theme = 'navbar-dark';
        }
        $paramView = [
            'theme' => $theme,
            'nav_theme' => $nav_theme,
            'loggedin' => true,
            'nextEvent' => null,
            'commuFlow' => null,
        ];
        if(isset($_SESSION["user"])){
            $paramView['loggedin'] = true;
        }
        return $this->render('home/index.html.twig', $paramView);
    }

    /**
     * @Route("/{_locale}/login", name="log_in")
     */
    public function login(): Response
    {
        return $this->redirectToRoute('home');
    }
}
