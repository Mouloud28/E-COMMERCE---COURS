<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * BACK OFFICE
 * Préfixe de toutes les routes se trouvant dans ce controller
 * @Route("/admin/produit")
 */
class ProduitController extends AbstractController
{

    /*
        Ce controller contient les routes du CRUD
           CREATE       READ  UPDATE DELETE
        -> INSERT INTO SELECT UPDATE DELETE

    */

    /**
     * Cette route va afficher tous les produits de la BDD
     * Requête SELECT
     * 
     * @Route("/afficher", name="produit_afficher")
     */
    public function produit_afficher(ProduitRepository $produitRepository): Response
    {
        /*
            Cette route va récupérer les produits en BDD
            Elle va dépendre d'un objet de la class ProduitRepository

            il existe des méthodes pour récupérer des produits
            - findAll() => SELECT * FROM produit
            - find($int) => SELECT * FROM produit WHERE id = $int

            il y a 2 'types' de méthodes :
                - return un tableau d'objets
                - return un objet/null

            Les dépendances se plaçent dans les parenthèses de la fonction
            Syntaxe : Class $objet
        */

        $produits = $produitRepository->findAll();
        dump($produits);

        return $this->render('produit/produit_afficher.html.twig',[
            'produits' => $produits
        ]);
    }


    /**
     * Ajouter par un formulaire un produit en bdd
     * requête INSERT INTO
     * 
     * @Route("/ajouter", name="produit_ajouter")
     */
    public function produit_ajouter(Request $request, EntityManagerInterface $em): Response
    {
        // Instancier un objet de la Class (Entity) Produit
        $produit = new Produit();
        // Rappel : l'objet récupère ce qui se trouve dans la class : propriétés et méthodes 

        // $produit->setTitre('hello');
        dump($produit);

        /*
            La méthode createForm() provenant de la Class AbstractController
            1 argument : nom de Class contenant l'objet $builder (ClassType)
            2 argument : objet issu de l'entity qui également permis la création du $builder

        */
        $form = $this->createForm(ProduitType::class,$produit);
        // $form est un objet, donc il contient des méthodes

        // traitement du formulaire
        $form->handleRequest($request);

        // si le formulaire a été soumis et si le formulaire est conforme/valide aux conditions/constraints
        if ($form->isSubmitted() AND $form->isValid()) {
            # insertion en bdd
            //dd($produit);
            // la méthode persist() permet d'insérer ou de modifier en bdd
            // (et la méthode remove() permet de supprimer)
            // dans quelle table ?  l'argument est un objet issu d'une entity (=table)
            $em->persist($produit);
            $em->flush();

            //dd($produit);

            // notification

            // redirection
            // méthode redirectToRoute() : équivalent de la fonction twig path() 
            // mêmes arguments : 
            // 1e obligatoire (str) : NOM DE LA ROUTE
            // 2e facultatif (array) : tableau des paramètres

            return $this->redirectToRoute('produit_afficher');
        }



        return $this->render('produit/produit_ajouter.html.twig', [
            'formProduit' => $form->createView(), // création du code HTML

        ]);
    }


    /**
     * @Route("/fiche/{id}", name="produit_fiche")
     */                                     
    public function produit_fiche(Produit $produit): Response
    {
        //                       $id, ProduitRepository $produitRepository
        //$produit = $produitRepository->find($id);
        //dd($produit);

        
        return $this->render('produit/produit_fiche.html.twig', [
            'produit' => $produit
        ]);
    }

    /**
     * Requête UPDATE
     * @Route("/modifier/{id}", name="produit_modifier")
     */
    public function produit_modifier(Produit $produit, Request $request, EntityManagerInterface $em): Response
    {
        /*
            Après observation, ajouter et modifier nécessite le même code 
            à l'exception de l'objet produit
            - quand on ajoute, on génère un objet
            - quand on modifie, on récupère de la bdd un objet (grâce au paramètre dans l'url)
        */

        
        $form = $this->createForm(ProduitType::class, $produit);

        $form->handleRequest($request);

        if($form->isSubmitted() AND $form->isValid())
        {
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_afficher');
        }

        return $this->render('produit/produit_modifier.html.twig',[
            'formProduit' => $form->createView()
        ]);
    }


    /**  
     * Requête DELETE
     * @Route("/supprimer/{id}", name="produit_supprimer")
     */
    public function produit_supprimer(Produit $produit, EntityManagerInterface $em): Response
    {
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('produit_afficher');
    }



}
