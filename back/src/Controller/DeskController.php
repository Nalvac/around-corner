<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Desks;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class DeskController extends AbstractController
{

  private $entityManager;
  private $serializer;

  public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
  {
      $this->entityManager = $entityManager;
      $this->serializer = $serializer;
  }

    /**
     * Afficher tout les bureaux 
    */
    #[Route('/api/desk_all', name: 'app_desk_all')]
    public function all_desk(): Response
    {
      $desks = $this->entityManager->getRepository(Desks::class)->findAll();
      $data = [];
      
      foreach ($desks as $desk) {

        // On fait la moyenne des notes pour chaque bureau, s'il n'y a pas de note on retourn null
        $bookings = $desk->getBookings();
        $numBookings = count($bookings);
        $sumNotes = 0;

        foreach ($bookings as $booking) {
            $sumNotes += $booking->getNote();
        }

        $averageNote = $numBookings > 0 ? $sumNotes / $numBookings : null;
  

          $data[] = [
              'id' => $desk->getId(),
              'price' => $desk->getPrice(),
              'adress' => $desk->getAdress(),
              'city' => $desk->getCity(),
              'zipCode' => $desk->getZipCode(),
              'averageNote' => $averageNote,
              // 'description' => $desk->getDescription(),
              // 'numberPlaces' => $desk->getNumberPlaces(),
              // 'status_desks_id' => $desk->getStatusDesks()->getName(),
              // 'user_id' => $desk->getUsers()->getId(),

          ];
      }
      
      $response = new JsonResponse();
      $response->setContent(json_encode($data));
      $response->setStatusCode(Response::HTTP_OK);
      $response->setData(['data' => $data]);
          
      return $response;
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
