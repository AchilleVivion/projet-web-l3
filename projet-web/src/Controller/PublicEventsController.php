<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicEventsController extends AbstractController
{
    /**
     * @Route("/{_locale}/public/events", name="public_events")
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
        ];
        return $this->render('public_events/index.html.twig', $paramView);
    }
}
