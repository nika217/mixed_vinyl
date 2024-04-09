<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    #[Route('/', name: 'vinyl')]
    public function homePage() : Response
    {
        return new Response('Vinyl page');
    }
    #[Route('/browse/{slug}', name: 'browse')]
    public function browse(string $slug = null) : Response
    {
        if ($slug)
        {
            $title = u(str_replace('-', ' ', $slug))->title(true);
        }
        else
        {
            $title = 'All Genres';
        }

        return new Response($title);
    }
}