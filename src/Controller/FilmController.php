<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Genre;
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
     * @Route("/", name="film_index")
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
     * @Route("/{id}/edit", name="film_edit")
     */
    public function add_edit (Film $film = null, Request $request){
        // si le film n'existe pas, on instancie un nouveau film (on est dans le cas d'un ajout)
        if (!$film) {
            $film = new Film();
        }
         // il faut créer un filmType au préalable (php bin/console make:form
         $form = $this->createForm(FilmType::class, $film);

         $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
       if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les données du formulaire
           $film = $form->getData();
           // on ajoute le nouveau film
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($film);
           $entityManager->flush();
           // on redirige vers la liste des film 
           return $this->redirectToRoute('film_index');
       }
       
       /* on renvoie à la vue correspondante : 
           - le formulaire
           - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
       */
       return $this->render('film/add_edit.html.twig', [
           'formFilm' => $form->createView(),
           'editMode' => $film->getId() !== null
       ]);
   }
   /**
    * @Route("/{id}/remove", name="film_remove", methods="GET")
    */
    public function remove(Film $film){
        $id = $film->getId();
        $film = $this->getDoctrine()
                ->getRepository(Film::class)
                ->deleteOneById($id);
        return $this->redirectToRoute('film_index');
    }   

    /**
     * @Route("/{id}", name="film_show", methods="GET")
     */
    public function schow(Film $film): Response {
        return $this->render('film/show.html.twig',[
            'film'=>$film
            ]);
    }
    
}
