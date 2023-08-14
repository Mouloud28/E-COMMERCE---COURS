<?php

namespace App\Controller; // App = src : 'localisation de la class'

// importation (IL FAUT TOUJOURS IMPORTER LES CLASS)

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController // Héritage de la class AbstractController
{



    /**
     * arguments de la route :
     * 
     * 1- ROUTE (URL)
     * serveur + ROUTE
     * serveur en local : 127.0.0.1:8000
     * serveur en ligne : www.nomDeDomaine.fr
     * 
     * 2- NOM DE LA ROUTE (liens)
     * 
     * 
     * @Route("/test", name="testName")
     * @IsGranted("ROLE_ADMIN")
     */
    public function testing() : Response
    {

        // la méthode render() provient de la class héritée AbstractController
        // Elle permet de retourner un template (une view : un fichier html.twig)
        // Elle a 1 argument obligatoire (STR): le nom du fichier situé dans le dossier templates
        // Elle a 2e argument facultatif (ARRAY) : tableau des données de la fonction à transmettre au template
        return $this->render('front/test.html.twig', []);
    }

    /** 
     * Route principale du site
     * @Route("/", name="home")
     */
    public function accueil(): Response
    {
        $prenomController = 'bart';
        dump($prenomController); // debug visible dans le Profiler Symfony
        // Dans le dump on peut y placer variable, tableau, objet, tableau d'objets etc..
        $prenomController = 'louis';
        //dump($prenomController);die;
        //dd($prenomController);
        // tout le code après "die" n'est pas éxecuté, seuls les dumps seront visibles sur le navigateur

        // /!\ attention quand le site est en ligne c'est-à-dire en mode "prod" (fichier .env) il faut s'assurer que tous les dumps soit commentés ou supprimés

        return $this->render('front/home.html.twig',[
            // key => value
            // key : 'terme'(variable, tableau, objet) récupéré en twig
            // value : 'terme' provenant de la fonction
            'prenomTwig' => $prenomController

        ]);
    }


    /**
     * FRONT OFFICE
     * Requête SELECT de la table produit 
     * 
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(ProduitRepository $produitRepository) : Response
    {
        $produits = $produitRepository->findAll();
        return $this->render('front/catalogue.html.twig', [
            'produits' => $produits
        ]);
    }







} // RIEN EN DESSOUS DE LA CLASS





    /**
     * Annotation
     * Syntaxe : DOUBLE QUOTE et EGAL
     * @Route("", name="")
     */

     // Attribut (depuis Symfony 6)
     // Syntaxe : SIMPLE QUOTE et DEUX POINTS
     // #[Route('', name:'')]


     /*
        Pour créer une route :
        - Créer l'annotation/attribut de la route
        - Créer la fonction associée à la route juste en dessous
        - Cette fonction va retourner un template (view)
        - Créer le fichier.html.twig et le définir comme 1e argument de la méthode render()
        - Alimenter le template
            

     */