<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/genre")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="genre_index")
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

     /**
     * @Route("/add", name="genre_add")
     * @Route("/{id}/edit", name="genre_edit")
     */
    public function add_edit (Genre $genre = null, Request $request){
        // si le genre n'existe pas, on instancie un nouveau genre (on est dans le cas d'un ajout)
        if (!$genre) {
            $genre = new Genre();
        }
         // il faut créer un GenreType au préalable (php bin/console make:form
         $form = $this->createForm(GenreType::class, $genre);

         $form->handleRequest($request);
        // si on soumet le formulaire et que le form est valide
       if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les données du formulaire
           $genre = $form->getData();
           // on ajoute le nouveau genre
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($genre);
           $entityManager->flush();
           // on redirige vers la liste des genre 
           return $this->redirectToRoute('genre_index');
       }
       
       /* on renvoie à la vue correspondante : 
           - le formulaire
           - le booléen editMode (si vrai, on est dans le cas d'une édition sinon on est dans le cas d'un ajout)
       */
       return $this->render('genre/add_edit.html.twig', [
           'formGenre' => $form->createView(),
           'editMode' => $genre->getId() !== null
       ]);
   }
}
