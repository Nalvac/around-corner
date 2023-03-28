<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeskController extends AbstractController
{
    /**
     * Afficher tout les bureaux 
    */
    #[Route('/api/desk', name: 'app_desk')]
    public function index(): Response
    {
        return $this->render('desk/index.html.twig', [
            'controller_name' => 'DeskController',
        ]);
    }

    /**
     * Editer un bureau
    */

    /**
      * Supprimer un bureau
    */

    /**
     * Ajouter une option à un bureau
    */

    /**
      *  Filter les bureaux
    */

    /**
     * Ajouter des images
     */

    /**
    * Ajouter date de disponibilité
    */

    // /**
    //  * Ajouter au like
    //  */

    // /**
    //  * Voir tout ses like
    // */

    /**
     * Afficher les bureaux qu'un utilisateur a mis en location
     */




}
