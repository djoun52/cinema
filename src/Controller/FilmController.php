<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/film")
 */
class FilmController extends AbstractController
{
    /**
     * @Route("/", name="film")
     */
    public function index()
    {
        $films=$this->getDoctrine()
            ->getRepository(Film::class)
            ->getAll();
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }


     /**
     * @Route("/add", name="film_add")
     */
    public function add(Film $film, Request $request){
        if (!$film) {
            $film = new Film();
        }
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        
        return $this->render('film/new.html.twig', [
             'FormFilm'=> $form->createView()
         ]);
    }
}
