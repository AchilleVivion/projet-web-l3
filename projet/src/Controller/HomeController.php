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
        return $this->render('home/index.html.twig', $paramView);
    }

    /**
     * @Route("/{_locale}/login", name="log_in")
     */
    public function login(): Response
    {
        $session = $this->container->get('session');
        $session->set('token', 'token set');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/{_locale}/logout", name="log_out")
     */
    public function logout(): Response
    {
        $session = $this->container->get('session');
        $session->remove('token');
        return $this->redirectToRoute('home');
    }
}
