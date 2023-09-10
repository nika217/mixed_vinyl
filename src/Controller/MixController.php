<?php

namespace App\Controller;

use App\Entity\VinylMix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MixController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/mix/new')]
    public function new(): Response
    {
        $mix = new VinylMix();
        $mix->setTitle('Test title');
        $mix->setDescription('test desc');
        $genres = ['pop', 'rock'];
        $mix->setGenre($genres[array_rand($genres)]);
        $mix->setTrackCount(rand(5, 20));
        $mix->setVotes(rand(-50, 50));

        $this->entityManager->persist($mix);
        $this->entityManager->flush();

        return new Response(sprintf(
            'Mix %d is %d tracks of pure 80\'s heaven',
            $mix->getId(),
            $mix->getTrackCount()
        ));
    }

    #[Route('/mix/{id}', name: 'app_mix_show')]
    public function show(VinylMix $mix) : Response
    {
        return $this->render('mix/show.html.twig', [
            'mix' => $mix
        ]);
    }

    #[Route('/mix/{id}/vote', name: 'app_mix_vote', methods: ['POST'])]
    public function vote(VinylMix $mix, Request $request) : Response
    {
        $direction = $request->request->get('direction');
        if($direction === 'up'){
            $mix->upVote();
        }else {
            $mix->downVote();
        }

        $this->entityManager->flush();

        $this->addFlash('success', 'Vote counted!');

        return  $this->redirectToRoute('app_mix_show', [
            'id' => $mix->getId()
        ]);
    }
}