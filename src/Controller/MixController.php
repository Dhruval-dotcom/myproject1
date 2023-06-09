<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    #[Route('/mix/new', name: 'app_mix')]
    public function index(EntityManagerInterface $entityManager): Response
    {
 
        $mix = new VinylMix();
        $mix->setTitle('Do you Remember... Phil Collins?!');
        $mix->setDescription('A pure mix of drummers turned singers!');
        $mix->setGenre('rock');
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $entityManager->persist($mix);
        $entityManager->flush(); 

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));

        // return $this->render('mix/index.html.twig', [
        //     'controller_name' => 'MixController',
        // ]);
    }
}
