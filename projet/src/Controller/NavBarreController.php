<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavBarreController extends AbstractController
{
    /**
     * @Route("/settings", name="nav_barre")
     */
    public function index(): Response
    {
        $session = $this->container->get('session');
        $lang = $_POST['lang_setting'];
        $host = $_SERVER['HTTP_HOST'];
        $referer = $_SERVER['HTTP_REFERER'];
        $route = isset(preg_split("/\/..\//", $referer)[1]) ? preg_split("/\/..\//", $referer)[1] : "";
        $nav_settings['lang'] = $lang;
        if(isset($_POST['theme_setting'])){
            $session->set('theme', 'darktly');
            $session->set('nav_theme', 'navbar-dark');
            $nav_settings['theme'] = true;
        }
        else{
            $session->set('theme', 'flatly');
            $session->set('nav_theme', 'navbar-light');
            $nav_settings['theme'] = false;
        }
        $session->set('nav_settings', $nav_settings);
        return $this->redirect("http://$host/$lang/$route");
    }
}
