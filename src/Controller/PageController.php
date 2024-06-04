<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository, ParameterBagInterface $parameterBag): Response
    {
        $movies = $movieRepository->findBy([], ['id' => 'DESC'], $parameterBag->get('home_movies_limit'));

        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'movies' => $movies,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('page/about.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
