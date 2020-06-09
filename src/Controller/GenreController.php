<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/genre", name="genre")
     */
    public function index()
    {
        $genres=$this->getDoctrine()
            ->getRepository(Genre::class)
            ->getAll();
        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }
}
