<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApihandlerController extends AbstractController
{
    #[Route('/api/songs/{id<\d+>}', name: 'app_apihandler', methods: ['GET'] )]
    public function index(int $id, LoggerInterface $logger)
    {
        //dd($id);
        // return $this->render('apihandler/index.html.twig', [
        //     'controller_name' => 'ApihandlerController',
        // ]);

        $song = [
            'id' => $id,
            'name' => 'Waterfalls',
            'url' => 'https://songs.com'
        ];

        $logger -> info('Returning API response for song {song}',[
            'song' => $id,
        ]);

        return new JsonResponse($song); 
        //return $this->json($song);
    }
}
