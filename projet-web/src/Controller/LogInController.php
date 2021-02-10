<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogInController extends AbstractController
{
    /**
     * @Route("/login", name="log_in")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'theme' => 'darktly',
            'loggedin' => false,
        ]);
    }
}
