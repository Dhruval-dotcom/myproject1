<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    #[Route('/', name: 'app_new')]
    public function index2()
    {
        // return $this->render('new/index.html.twig', [
        //     'controller_name' => 'NewController',
        // ]);

        //die('Heelo');
        return new Response('Hello');
    }

    #[Route('/profile/{slug}', name: 'app_new')]
    public function index($slug = null)
    {
        if ($slug) {
            $title = 'Genre: '.str_replace('-', ' ', $slug);
        } else {
            $title = 'All genre';
        }
        return new Response('Hello '.$title);
    }
}
