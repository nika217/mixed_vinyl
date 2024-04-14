<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'vinyl')]
    public function homePage(): Response
    {
        $tracks = [
            ['song' => 'Music', 'number' => 1],
            ['song' => 'Music', 'number' => 2],
            ['song' => 'Music', 'number' => 3],
            ['song' => 'Music', 'number' => 4],
            ['song' => 'Music', 'number' => 5],
            ['song' => 'Music', 'number' => 6],
            ['song' => 'Music', 'number' => 7],
        ];
        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
    }

    #[Route('/browse/{slug}', name: 'browse')]
    public function browse(string $slug = null): Response
    {
        if ($slug) {
            $title = u(str_replace('-', ' ', $slug))->title(true);
        } else {
            $title = 'All Genres';
        }

        return new Response($title);
    }
}