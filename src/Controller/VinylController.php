<?php

namespace App\Controller;

use App\Service\MixRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    public function __construct(
        private MixRepository $mixRepository
    )
    {}

    #[Route('/', name: 'app_homepagee')]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];

        return $this->render('vinyl/homepagee.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'app_browsee')]
    public function browse( MixRepository $mixRepository,string $slug = null): Response
    {
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
//menyra 1 me metoden poshte        $mixes = $this->getMixes();

// menyra 2 nga repo ne github       $response = $httpClient->request('GET', 'https://raw.githubusercontent.com/SymfonyCasts/vinyl-mixes/main/mixes.json')
//        ;//from the website(repo in github) where info is saved
//        $mixes =$response->toArray();//to decode that JSON into a $mixes array.

        $mixes = $mixRepository->findAll();

        return $this->render('vinyl/browsee.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }

//    private function getMixes(): array
//    {
//        // temporary fake "mixes" data
//        return [
//            [
//                'title' => 'PB & Jams',
//                'trackCount' => 14,
//                'genre' => 'Rock',
//                'createdAt' => new \DateTime('2021-10-02'),
//            ],
//            [
//                'title' => 'Put a Hex on your Ex',
//                'trackCount' => 8,
//                'genre' => 'Heavy Metal',
//                'createdAt' => new \DateTime('2022-04-28'),
//            ],
//            [
//                'title' => 'Spice Grills - Summer Tunes',
//                'trackCount' => 10,
//                'genre' => 'Pop',
//                'createdAt' => new \DateTime('2019-06-20'),
//            ],
//        ];
//    }
}
