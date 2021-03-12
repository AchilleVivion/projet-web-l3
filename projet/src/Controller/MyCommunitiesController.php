<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyCommunitiesController extends AbstractController
{
    /**
     * @Route("/{_locale}/my/communities", name="my_communities")
     */
    public function index(): Response
    {
        $session = $this->container->get('session');
        if(!$session->has('theme')){
            $session->set('theme', 'flatly');
        }
        if(!$session->has('nav_theme')){
            $session->set('nav_theme', 'navbar-light');
        }
        if(!$session->has('nav_settings')){
            $session->set('nav_settings', [
                'lang' => 'en',
                'theme' => 'off',
            ]);
        }
        $paramView = [
            'theme' => $session->get('theme'),
            'nav_theme' => $session->get('nav_theme'),
            'nextEvent' => null,
            'commuFlow' => null,
            'nav_settings' => $session->get('nav_settings'),
        ];
        if($session->has('token')){
            $paramView['loggedin'] = true;
        }
        return $this->render('my_communities/index.html.twig', $paramView);
    }
}
