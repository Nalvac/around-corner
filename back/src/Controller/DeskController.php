<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Options;
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
        $tabImage = [];
        $images = $this->entityManager->getRepository(Images::class)->findBy(['desks' => $desk->getId()]);

        foreach ($images as $image) {
            $tabImage[$image->getId()] = $image->getLink();
        }


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
            'tax' => $desk->getTax(),
            'adress' => $desk->getAdress(),
            'city' => $desk->getCity(),
            'zipCode' => $desk->getZipCode(),
            'averageNote' => $averageNote,
            // 'description' => $desk->getDescription(),
            'numberPlaces' => $desk->getNumberPlaces(),
            'images' => $tabImage,
            'status_desks_id' => $desk->getStatusDesks()->getName(),
            // 'status_desks_id' => $desk->getStatusDesks()->getName(),
            // 'user_id' => $desk->getUsers()->getId(),

        ];
      }

      return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * Afficher un seul bureau
     */
    #[Route('/api/desk/{id}', name: 'app_desk', methods: ['GET'])]
    public function desk($id): Response
    {
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($id);
      $tabImage = [];
      $images = $this->entityManager->getRepository(Images::class)->findBy(['desks' => $desk->getId()]);
      foreach ($images as $image) {
          $tabImage[$image->getId()] = $image->getLink();
      }
      
      // On fait la moyenne des notes pour le bureau, s'il n'y a pas de note on retourn null
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
          'description' => $desk->getDescription(),
          'numberPlaces' => $desk->getNumberPlaces(),
          'images' => $tabImage,
          'status_desks_id' => $desk->getStatusDesks()->getName(),
          'user_id' => $desk->getUsers()->getId(),
      ];

      return new JsonResponse($data,Response::HTTP_OK);
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
    public function add_desk(Request $request): Response
    {
      $desk = new Desks();
      $data = json_decode($request->getContent(), true);
      $user = $this->entityManager->getRepository(Users::class)->findOneById($data["uid"]);
      if($user->getIsCertified() === false){
        return new JsonResponse('Sorry, you need to be certified to perform this action.', Response::HTTP_NOT_FOUND);
      }

      $images = $data['images'];
      $statusDesks = $this->entityManager->getRepository(StatusDesks::class)->findOneById($data["sdid"]);
      $calcPriceTax = ($data['tax'] / 100) * $data['price'] + $data['price'];
      $desk->setPrice($calcPriceTax);
      $desk->setAdress($data['address']);
      $desk->setCity($data['city']);
      $desk->setZipCode($data['zipCode']);
      $desk->setDescription($data['description']);
      $desk->setNumberPlaces($data['numberPlaces']);
      $desk->setTax($data['tax']);
      $desk->setUsers($user);
      $desk->setStatusDesks($statusDesks);

    foreach ($images as $image){
        $obImage = new Images();
        $obImage->setLink($image);
        $obImage->setDesks($desk);
        $this->entityManager->persist($obImage);
    }

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
    #[Route('/api/desk/{id}/option', name: 'app_desk_add_option', methods: ['POST'])]
    public function add_option_desk(Request $request, string $id): Response
    {
        $data = json_decode($request->getContent(), true);
        $desk = $this->entityManager->getRepository(Desks::class)->findOneById($id);
        $option = $this->entityManager->getRepository(Options::class)->findOneById($data['optionId']);

        if (isset($option) && isset($desk)) {
            $desk->addOption($option);
            $this->entityManager->persist($desk);
            $this->entityManager->flush();

            return new JsonResponse(
                [
                    'message' => 'option a été ajouté au bureau',
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse(
                [
                    'message' => 'Invalid! Soit l option n existe pas soit le bureau n existe pas',
                ], Response::HTTP_OK
            );
        }

    }

    /**
     * Enlever une option à un bureau
    */
    #[Route('/api/desk/{desk_id}/option/{option_id}', name: 'app_desk_delete_option', methods: ['DELETE'])]
    public function delete_option_desk(Request $request, string $desk_id, string $option_id): Response
    {
        $desk = $this->entityManager->getRepository(Desks::class)->findOneById($desk_id);
        $option = $this->entityManager->getRepository(Options::class)->findOneById($option_id);

        if (isset($option) && isset($desk)) {
            $desk->removeOption($option);
            $this->entityManager->persist($desk);
            $this->entityManager->flush();

            return new JsonResponse(
                [
                    'message' => 'option a été supprimé du bureau',
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse(
                [
                    'message' => 'Invalid! Soit l option n existe pas soit le bureau n existe pas',
                ], Response::HTTP_OK
            );
        }

    }
    

    /**
      *  Filter les bureaux par nombre de place, ville, option, date (pas reservé), par type de salle, price
    */
    #[Route('/api/desk/search', name: 'app_desk_search_filter', methods: ['POST'])]
    public function search_desk(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $desks = $this->entityManager->getRepository(Desks::class)->getDeskWithFilter($data);

        foreach ($desks as $desk) {
            foreach ($desk->getOptions() as $option) {
                $tabDesk = [];
                if (in_array($option->getId(), $data['option'],true)) {
                    $tabDesk[] = $desk;
                }
            }
            foreach ($desk->getAvailabilities() as $avaibility) {
                $tabDesk = [];
                if ($avaibility->getStartDate() == new \DateTime($data['startDate']) and $avaibility->getStartDate() == new \DateTime($data['endDate'])) {
                    $tabDesk[] = $desk;
                }
            }
        }

        if (!empty($tabDesk)) {
            foreach ($tabDesk as $desk) {
                $content = json_decode(self::desk($desk->getId())->getContent());
                return new JsonResponse(
                    $content
                    , Response::HTTP_OK
                );
            }
        } else {
            return new JsonResponse(
                [
                    'message' => 'On a trouvé aucun bureaux',
                ], Response::HTTP_OK
            );
        }
    }


    /**
     * Ajouter des images
    */
    #[Route('/api/desk-add-image', name: 'app_desk_add_image', methods: ['POST'])]
    public function add_desk_image(Request $request): Response
    {
      $data = json_decode($request->getContent(), true);
      $images = $data['images'];
     
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($data["did"]);
      
      foreach ($images as $image){
        $obImage = new Images();
        $obImage->setLink($image);
        $obImage->setDesks($desk);
        
        $this->entityManager->persist($obImage);
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
    #[Route(path: 'api/desk-delete-image/{id}', name: 'api_delete_image', methods: ['DELETE'])]
    public function desk_delete_image(string $id): JsonResponse
    {
        $image = $this->entityManager->getRepository(Images::class)->findOneById($id);
        if ($image == null) {
            return new JsonResponse('Sorry, image does not exist', Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($image);
        $this->entityManager->flush();
        return new JsonResponse(
            [
                'message' => "Image is deleted",
            ], Response::HTTP_OK
        );
    }

    /**
    * Ajouter date de disponibilité
    */
    #[Route('/api/desk-add-availability', name: 'app_desk_add_availability', methods: ['POST'])]
    public function add_desk_availability(Request $request): Response
    {
      $availability = new Availability();
      $data = json_decode($request->getContent(), true);
      $desk = $this->entityManager->getRepository(Desks::class)->findOneById($data["did"]);
      
      $availability->setStartDate(new \DateTime($data['startDate']));
      $availability->setEndDate(new \DateTime($data['startDate']));
      $availability->setDesks($desk);
      
      $this->entityManager->persist($availability);
      $this->entityManager->flush();

      return new JsonResponse(
        [
            'message' => "Availability is added",
        ], Response::HTTP_OK
      );
    }

    // /**
    // * Supprimer une date de disponibilité lié a un bureau pour l'instant impossible, car on enregistre les dates en créneau. Le jour
    // * ou on mets en place les demi journée en gros on enregistrera chaque demi journée par demi journée dans la bdd, donc a ce moment
    // * on pourra supprimer des demis journées et pas un un créneau
    // */
    

    /**
     * Afficher les dates de dispo d'un bureau pour l'owner (avec un tableau json qui renvoie les dates prise et l'utilisateur qui a pris)
    */


    /**
    * Afficher les dates de dispo pour un hotel en vérifiant que les dates de dispo sont pas utiliser par un autre user
    */

    // A faire dans le futur
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
    public function all_desk_by_owner(string $id): Response
    {

      $desks =  $this->entityManager->getRepository(Desks::class)->findBy(['owners' => $id]);
      $data = [];
      $tabImage = [];

      foreach ($desks as $desk) {
          $images = $this->entityManager->getRepository(Images::class)->findBy(['desks' => $desk->getId()]);
          foreach ($images as $image) {
              $tabImage[$image->getId()] = $image->getLink();
          }

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
            'image' => $tabImage
        ];
      }
      return new JsonResponse($data,Response::HTTP_OK);
    }
}
