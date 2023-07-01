<?php

namespace App\Controller;

use App\Entity\VinylMix;
use App\Repository\TableTwoRepository;
use App\Repository\VinylMixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Bundle\TimeBundle\DateTimeFormatter;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;
use function Symfony\Component\String\u;

class NewController extends AbstractController
{
    public function __construct(
        private bool $isDebug,
        private Environment $twig
    ) {

    }

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
    public function index_demo(DateTimeFormatter $timeformatter, Environment $twig): Response
    {
        $track = ['a', 'b', 'c'];
        $arr = [
            [
                'a' => 1,
                'b' => 2,
                'createdAt' => new \DateTime('2021-10-02')
            ],
            [
                'a' => 3,
                'b' => 4,
                'createdAt' => new \DateTime('2023-04-28')
            ],
            [
                'a' => 1,
                'b' => 5,
                'createdAt' => new \DateTime('2019-06-20')
            ],
            [
                'a' => 1,
                'b' => 6,
                'createdAt' => new \DateTime('2023-01-28')
            ]
        ];
        foreach ($arr as $key => $val) {
            $arr[$key]['ago'] = $timeformatter->formatDiff($arr[$key]['createdAt']);
        }

        $html = $twig->render('new/homepage.html.twig', [
            'title' => 'Hello guys in twig',
            'smalltitle' => 'Hello small',
            "tracks" => $track,
            'arr' => $arr,
        ]);

        return new Response($html);
    }

    #[Route('/profile/{slug}', name: 'app_new')]
    public function SongPage(VinylMixRepository $mixRepository,TableTwoRepository $tableTwoRepository, Request $request, $slug = null)
    {
        // $response = $httpclient -> request('GET','https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json');
        //dump($cache);
        //dd($this->getParameter('kernel.project_dir'));
        //$mixes = $this -> mixRepository -> findAll();
        // $mixRepository = $entityManager->getRepository(VinylMix::class);
        // $mixes = $mixRepository->findBy([], ['votes' => 'DESC']);


        $queryBuilder = $mixRepository->createOrderedByVotesQueryBuilder($slug);
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page',1),
            5
        );
        $title = 'All Songs ' . u(str_replace('-', ' ', $slug))->title(true);
        $html = $this->twig->render('new/profile.html.twig', [
            'title' => $title,
            'pager' => $pagerfanta
        ]);

        return new Response($html);

        // $title = 'All genre ' . $slug;
        // return new Response('Hello '.$title);
    }

    #[Route('/allsongs/{page<\d+>}', name: 'allsongs')]
    public function AllSongPage(VinylMixRepository $mixRepository , int $page = 1)
    {
        $title = 'All Songs';

        $queryBuilder = $mixRepository->createSongOrderByNewestQueryBuilder();
        $pagerfanta = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );

        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($page);
        $html = $this->twig->render('new/allsongs.html.twig', [
            'title' => $title,
            'pager' => $pagerfanta
        ]);

        return new Response($html);

    }

    // #[Route('/mix/{id}', name: 'singleid')]
    // public function show($id, VinylMixRepository $mixRepository): Response
    // {
    //     $mix = $mixRepository->find($id);

    //     if(!$mix){
    //         throw $this->createNotFoundException('Mix Not Found');
    //     }

    //     dd($mix);
    //     return $this->render('mix/show.html.twig', [
    //         'mix' => $mix,
    //     ]);
    // }

    #[Route('/mix/{slug}', name: 'singleid')]
    public function show(VinylMix $mix, TableTwoRepository $tableTwoRepository): Response
    {

        $answer = $tableTwoRepository->findBy(
            ['question' => $mix], 
            ['createdAt' => 'DESC']
        );

        return $this->render('mix/show.html.twig', [
            'mix' => $mix,
            'answer'=> $mix->getApprovedAns()
        ]);
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $direction = $request->request->get('direction', 'up');
        if ($direction === 'up') {
            $mix->upvote();
        } else {
            $mix->downvote();
        }

        $entityManager->flush();
        $this->addFlash('success', 'Vote counted!');   //stored in users session
        return $this->redirectToRoute('singleid', [
            'slug' => $mix->getSlug(),
        ]);
        
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote')]
    public function answervote(VinylMix $mix, Request $request, LoggerInterface $logger, EntityManagerInterface $entityManager): Response
    {
        
        $data = json_decode($request->getContent(), true);
        $direction = $data['direction'] ?? 'up';

        // use real logic here to save this to the database
        if ($direction === 'up') {
            $logger->info('Voting up!');
            $mix->setVotes($mix->getVotes() + 1);
        } else {
            $logger->info('Voting down!');
            $mix->setVotes($mix->getVotes() - 1);
        }

        $entityManager->flush();

        return $this->json(['votes' => $mix->getVotes()]);
        
    }

    #[Route('/mix/{id}', name: 'app_mix_vote2')]
    public function vote2(VinylMix $mix, EntityManagerInterface $entityManager): Response
    {   
        dd($mix);
        return $this->redirectToRoute('singleid', [
            'slug' => $mix->getSlug(),
        ]);   
    }

    #[Route('/popularanswers', name: 'popularanswers')]
    public function popularanswers(TableTwoRepository $tableTwoRepository, Request $request): Response
    {   
        return $this->render('commentanswer/popularanswers.html.twig', [
            'answer' => $tableTwoRepository->findMostPopular(
                $request->query->get('q')
            )
        ]);
    }
}
