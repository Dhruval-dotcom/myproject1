<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use function Symfony\Component\String\u;

class NewController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index2(): Response
    {
        return $this->render('new/index.html.twig', [
            'controller_name' => 'NewController',
        ]);

        //die('Heelo');
        // return new Response('Hello');
    }

    #[Route('/appdemo', name: 'appdemo')]
    public function index_demo(Environment $twig): Response
    {
        $track = ['a', 'b', 'c'];
        $arr = [
            ['a' => 1 , 'b' => 2],
            ['a' => 3 , 'b' => 4],
            ['a' => 1 , 'b' => 5],
            ['a' => 1 , 'b' => 6]
        ];
                        
         $html = $twig ->render('new/homepage.html.twig', [
            'title' => 'Hello guys in twig',
            'smalltitle' =>  'Hello small',
            "tracks" => $track,
            'arr' => $arr,
         ]);

         return new Response($html);
    }

    #[Route('/profile/{slug}', name: 'app_new')]
    public function index($slug = null)
    {
        if ($slug) {
            $title = 'Genre: '. u(str_replace('-', ' ', $slug)) -> title(true);
        } else {
            $title = 'All genre';
        }
        return new Response('Hello '.$title);
    }
}
