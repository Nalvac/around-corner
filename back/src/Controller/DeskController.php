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
use Symfony\Component\HttpFoundation\Request;

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
    #[Route('/api/desk-all', name: 'app_desk_all', methods: ['GET'])]
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

        // Les data commentés sont laissé pour le futur, si jamais on a besoin de tout les bureau ainsi que leur description etc... 
        // Il suffit juste de décomenté
        $data[] = [
            'id' => $desk->getId(),
            'price' => $desk->getPrice(),
            'adress' => $desk->getAdress(),
            'city' => $desk->getCity(),
            'zipCode' => $desk->getZipCode(),
            'averageNote' => $averageNote,
            // 'description' => $desk->getDescription(),
            'numberPlaces' => $desk->getNumberPlaces(),
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
     * 
    */
    #[Route('/api/desk-edit/{id}', name: 'app_desk_edit', methods: ['PUT'])]
    public function desk_edit($id, Request $request): JsonResponse
    {
      // schéma json attendu (si une donnée est manquante c'est pas grave et il ne faut pas de données en plus) : 
      // {
      //   "price": 25.0,
      //   "address": "123 rue de la ville",
      //   "city": "Paris",
      //   "zipCode": "75001",
      //   "description": "Bureau spacieux et lumineux",
      //   "numberPlaces": 2
      // }
      $data = json_decode($request->getContent(), true);
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($id);

      $desk->setPrice($data['price'] ?? $desk->getPrice());
      $desk->setAdress($data['address'] ?? $desk->getAdress());
      $desk->setCity($data['city'] ?? $desk->getCity());
      $desk->setZipCode($data['zipCode'] ?? $desk->getZipCode());
      $desk->setDescription($data['description'] ?? $desk->getDescription());
      $desk->setNumberPlaces($data['numberPlaces'] ?? $desk->getNumberPlaces());

      $this->entityManager->flush();

      return new JsonResponse(['message' => 'Le bureau est a jours.'], JsonResponse::HTTP_OK);
    }

    /**
      * Supprimer un bureau
    */


    /**
     * Ajouter une option à un bureau
    */

    /**
     * Enlever une option à un bureau
    */
    

    /**
      *  Filter les bureaux
    */

    /**
     * Ajouter des images
     */
    #[Route('/api/desk-add-image/{id}', name: 'desk_add_image', methods: ['GET'])]
    public function _add_image($id): Response
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

        // Les data commentés sont laissé pour le futur, si jamais on a besoin de tout les bureau ainsi que leur description etc... 
        // Il suffit juste de décomenté
        $data[] = [
            'id' => $desk->getId(),
            'price' => $desk->getPrice(),
            'adress' => $desk->getAdress(),
            'city' => $desk->getCity(),
            'zipCode' => $desk->getZipCode(),
            'averageNote' => $averageNote,
            // 'description' => $desk->getDescription(),
            'numberPlaces' => $desk->getNumberPlaces(),
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
