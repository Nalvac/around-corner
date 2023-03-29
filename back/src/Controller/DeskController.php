<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Desks;
use App\Entity\Users;
use App\Entity\StatusDesks;
use App\Entity\Availability;
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
        
        $images = $this->entityManager->getRepository(Images::class)->findBy(['desk' => $id]);

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
            'images' => $images,
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
     * Afficher un seul bureau
     */
    #[Route('/api/desk/{id}', name: 'app_desk', methods: ['GET'])]
    public function desk($id): Response
    {
      $desks = $this->entityManager->getRepository(Desks::class)->findOneById($id);
      $images = $this->entityManager->getRepository(Images::class)->findBy(['desk' => $id]);
      
      // On fait la moyenne des notes pour le bureau, s'il n'y a pas de note on retourn null
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
          'description' => $desk->getDescription(),
          'numberPlaces' => $desk->getNumberPlaces(),
          'images' => $images,
          'status_desks_id' => $desk->getStatusDesks()->getName(),
          'user_id' => $desk->getUsers()->getId(),
      ];
      
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
      * Ajouter un bureau
    */
    #[Route('/api/desk-add', name: 'app_desk_add', methods: ['POST'])]
    public function add_desk(): Response
    {

      $desk = new Desks();
      $data = json_decode($request->getContent(), true);
      $user = $this->entityManager->getRepository(Users::class)->findOneById($data["uid"]);
      if($user->getIsCertfied === false){
        throw new \Exception('Sorry, you need to be certified to perform this action.', Response::HTTP_NOT_FOUND);
      }

      $statusDesks = $this->entityManager->getRepository(StatusDesks::class)->findOneById($data["sdid"]);
      
      $desk->setPrice($data['price']);
      $desk->setAdress($data['address']);
      $desk->setCity($data['city']);
      $desk->setZipCode($data['zipCode']);
      $desk->setDescription($data['description']);
      $desk->setNumberPlaces($data['numberPlaces']);
      $desk->setUsers($user);
      $desk->setStatusDesks($statusDesks);
      
      $this->entityManager->persist($desk);
      $this->entityManager->flush();

      return new JsonResponse(
        [
            'message' => "Desk is added",
        ], Response::HTTP_OK
      );
    }


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
    #[Route('/api/desk-add-image', name: 'app_desk_add_image', methods: ['POST'])]
    public function add_desk_image(): Response
    {
      
      $data = json_decode($request->getContent(), true);
      $images = $data['images'];
     
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($data["did"]);
      
      foreach ($images as $image){
        $image = new Images();
        $image->setLink($image);
        $image->setDesks($desk);
        
        $this->entityManager->persist($image);
        $this->entityManager->flush();
      }
      

      return new JsonResponse(
        [
            'message' => "Image is/are added",
        ], Response::HTTP_OK
      );
    }

    /**
     * Supprimer une image lié a un bureau
    */

    

    /**
    * Ajouter date de disponibilité
    */
    #[Route('/api/desk-add-availability', name: 'app_desk_add_availability', methods: ['POST'])]
    public function add_desk_availability(): Response
    {
      $availability = new Availability();
      $data = json_decode($request->getContent(), true);
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($data["did"]);
      
      $availability->setStartDate($data['startDate']);
      $availability->setEndDate($data['endDate']);
      $availability->setDesks($desk);
      
      $this->entityManager->persist($availability);
      $this->entityManager->flush();

      return new JsonResponse(
        [
            'message' => "Availability is added",
        ], Response::HTTP_OK
      );
    }

    /**
    * Supprimer une date de disponibilité lié a un bureau
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
    #[Route('/api/desk-all-by-owner/{id}', name: 'app_desk_all_by_owner', methods: ['GET'])]
    public function all_desk_by_owner(): Response
    {

      $desk =  $this->entityManager->getRepository(Desks::class)->findBy(['user' => $id]);
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
            'description' => $desk->getDescription(),
            'numberPlaces' => $desk->getNumberPlaces(),
            'status_desks_id' => $desk->getStatusDesks()->getName(),
        ];
      }
      
      $response = new JsonResponse();
      $response->setContent(json_encode($data));
      $response->setStatusCode(Response::HTTP_OK);
      $response->setData(['data' => $data]);
          
      return $response;
    }




}
