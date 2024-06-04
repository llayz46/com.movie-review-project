<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class MovieController extends AbstractController
{
    #[Route('/films', name: 'app_movie')]
    public function index(MovieRepository $movieRepository, Request $request): Response
    {
        $genreId = $request->get('genreId');
        $movies = $movieRepository->findMoviesByGenre($genreId);

        // $movies = $movieRepository->findBy([], ['id' => 'DESC']);

        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/films/{id}', name: 'app_movie_show')]
    public function show(Movie $movie, Request $request, EntityManagerInterface $em, Security $security, ReviewRepository $reviewRepository, SessionInterface $session): Response
    {
        $session->set('previousPage', $request->getUri());

        $average = $reviewRepository->findAverageNoteByMovieId($movie->getId());

        $review = $reviewRepository->findOneBy([
            'movie' => $movie,
            'user' => $security->getUser()
        ]);

        if (!$review) {
            $review = new Review();
            $review->setMovie($movie);
            $review->setUser($security->getUser());
            $review->setApproved(false);
        }

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'form' => $form,
            'user' => $security->getUser(),
            'average' => $average
        ]);
    }
}
