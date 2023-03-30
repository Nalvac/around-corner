<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Entity\Desks;
use App\Entity\Users;
use App\Repository\BookingsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    /**
     * Récupérer toutes les réservations (utile pour le crud admin)
     */
    #[Route(path: 'api/booking', name: 'api_booking', methods: ['GET'])]
    public function options(BookingsRepository $bookingsRepository): JsonResponse
    {
        $models = $bookingsRepository->findAll();
        if (!empty($models)) {
            foreach ($models as $booking) {
                $data[] = [
                    'id' => $booking->getId(),
                    'user' => $booking->getUsers()->getId(),
                    'desk' => $booking->getDesks()->getId(),
                    'note' => $booking->getNote(),
                    'price' => $booking->getPrice(),
                    'opinion' => $booking->getOpinion(),
                    'startDate' => $booking->getStartDate(),
                    'endDate' => $booking->getEndDate(),
                    'created' => $booking->getCreated()
                ];
            }

            return new JsonResponse($data,Response::HTTP_OK);
        } else {
            return new JsonResponse('Aucune reservation disponible',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Supprimer/annuler une réservation via son id (il faut vérifier que la reservation se trouve avant 24h du début de cette dernière )
     */
    #[Route(path: 'api/booking/{id}', name: 'api_delete_booking', methods: ['DELETE'])]
    public function deleteBooking(BookingsRepository $bookingsRepository, string $id): JsonResponse
    {
        $booking = $bookingsRepository->findOneById($id);
        if (!$booking) {
            return new JsonResponse('Sorry, booking does not exist', Response::HTTP_NOT_FOUND);
        }

        $bookingsRepository->remove($booking,true);
        return new JsonResponse(
            [
                'message' => "Booking is deleted",
            ], Response::HTTP_OK
        );
    }

    /**
     * Mettre à jour une réservation (ajoute une note et un avis)
     */
    #[Route(path: 'api/booking/{id}', name: 'api_update_booking', methods: ['PATCH'])]
    public function editBooking(EntityManagerInterface $entityManager, Request $request, string $id): JsonResponse
    {
        $desksRepository = $entityManager->getRepository(Desks::class);
        $usersRepository = $entityManager->getRepository(Users::class);
        $bookingsRepository = $entityManager->getRepository(Bookings::class);

        $booking = $bookingsRepository->findOneById($id);

        if ($booking == null) {
            return new JsonResponse('Sorry, Booking does not exist', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );

        if (!empty($data["note"])){
            $note = $data["note"];
            $booking->setNote($note);
        }
        if (!empty($data["price"])){
            $price = $data["price"];
            $booking->setPrice($price);
        }
        if (!empty($data["opinion"])){
            $opinion = $data["opinion"];
            $booking->setOpinion($opinion);
        }
        if (!empty($data["userId"])){
            $userId = $data["userId"];
            $userId = $usersRepository->findOneById($userId);
            if (!is_null($userId))
                $booking->setUsers($userId);
            else
                return new JsonResponse("Invalid, This user Id does not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!empty($data["deskId"])){
            $deskId = $data["deskId"];
            $deskId = $desksRepository->findOneById($deskId);
            if (!is_null($deskId))
                $booking->setDesks($deskId);
            else
                return new JsonResponse("Invalid, This desk Id does not exists", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($booking);
        $entityManager->flush();

        return new JsonResponse(
            [
                'message' => "Booking is updated",
            ], Response::HTTP_OK
        );
    }

    /**
     * @throws \Exception
     */
    #[Route(path: 'api/booking', name: 'api_post_booking', methods: ['POST'])]
    public function addBooking(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $desksRepository = $entityManager->getRepository(Desks::class);
        $usersRepository = $entityManager->getRepository(Users::class);
        $bookingsRepository = $entityManager->getRepository(Bookings::class);

        $booking = new Bookings();
        //get data from body
        $data = json_decode(
            $request->getContent(),
            true
        );

        $userId = $data['userId'];
        $deskId = $data['deskId'];
        $note = $data['note'];
        $price = $data['price'];
        $opinion = $data['opinion'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];

        if (empty($userId) || empty($deskId) || empty($note) || empty($price) || empty($opinion) || empty($startDate) || empty($endDate)) {
            return new JsonResponse("Some data are empty! Check userId, deskId, note, price, opinion, startDate and endDate if empty", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId = $usersRepository->findOneById($userId);
        $deskId = $desksRepository->findOneById($deskId);

        if (is_null($userId)  or is_null($deskId)) {
            return new JsonResponse("Invalid! Check if userId or deskId exists", Response::HTTP_NOT_FOUND);
        } else {
            //start Date
            $startDate = strtotime($startDate);
            //end Date
            $endDate = strtotime($endDate);
            //current Date
            $currentDate = strtotime(date('d-m-Y'));

            if ($startDate < $currentDate)
                return new JsonResponse("Invalid! Veuillez mettre un startDate à partir d' aujourd'hui", Response::HTTP_NOT_FOUND);

            if ($endDate < $startDate)
                return new JsonResponse("Invalid! La date de sortie endDate est mis autant que startDate", Response::HTTP_NOT_FOUND);

            if ($startDate < $endDate or $startDate = $endDate) {
                $startDate = new \DateTime(date('d-m-Y',$startDate));
                $endDate = new \DateTime(date('d-m-Y',$endDate));

                if ($bookingsRepository->findAll()) {
                    $checkIfReservedStartDate = $bookingsRepository->findOneBy(['start_date' => $startDate]);
                    $checkIfReservedEndDate = $bookingsRepository->findOneBy(['endDate' => $endDate]);

                    if ($startDate = $checkIfReservedStartDate and $endDate = $checkIfReservedEndDate) {
                        return new JsonResponse("Sorry! Ce bureau est déjà réservé", Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                }

                $booking->setUsers($userId)
                    ->setDesks($deskId)
                    ->setNote($note)
                    ->setPrice($price)
                    ->setOpinion($opinion)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setCreated(new \DateTime(date('d-m-Y')));

            }

            $entityManager->persist($booking);
            $entityManager->flush();

            return new JsonResponse(
                [
                    'message' => "Booking is added",
                ], Response::HTTP_OK
            );
        }

    }
}