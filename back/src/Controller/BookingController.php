<?php

namespace App\Controller;

use App\Entity\Bookings;
use App\Entity\Desks;
use App\Entity\Users;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route(path: 'api/booking', name: 'api_booking', methods: ['GET'])]
    public function options(BookingsRepository $bookingsRepository): JsonResponse
    {
        $models = $bookingsRepository->findAll();
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
    }

    #[Route(path: 'api/booking/{id}', name: 'api_delete_booking', methods: ['DELETE'])]
    public function deleteBooking(BookingsRepository $bookingsRepository, string $id): JsonResponse
    {
        $booking = $bookingsRepository->findOneById($id);
        if (!$booking) {
            throw new \Exception('Sorry, booking does not exist', Response::HTTP_NOT_FOUND);
        }

        $bookingsRepository->remove($booking,true);
        return new JsonResponse(
            [
                'message' => "Booking is deleted",
            ], Response::HTTP_OK
        );
    }

    #[Route(path: 'api/booking/{id}', name: 'api_update_booking', methods: ['PATCH'])]
    public function editBooking(EntityManagerInterface $entityManager, Request $request, string $id): JsonResponse
    {
        $desksRepository = $entityManager->getRepository(Desks::class);
        $usersRepository = $entityManager->getRepository(Users::class);
        $bookingsRepository = $entityManager->getRepository(Bookings::class);

        $booking = $bookingsRepository->findOneById($id);

        if ($booking == null) {
            throw new \Exception('Sorry, Booking does not exist', Response::HTTP_NOT_FOUND);
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
            $booking->setUsers($userId);
        }
        if (!empty($data["deskId"])){
            $deskId = $data["deskId"];
            $deskId = $desksRepository->findOneById($deskId);
            $booking->setUsers($deskId);
        }

        $entityManager->persist($booking);
        $entityManager->flush();

        return new JsonResponse(
            [
                'message' => "Booking is updated",
            ], Response::HTTP_OK
        );
    }

    #[Route(path: 'api/booking', name: 'api_post_booking', methods: ['POST'])]
    public function addBooking(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $desksRepository = $entityManager->getRepository(Desks::class);
        $usersRepository = $entityManager->getRepository(Users::class);

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

        if (empty($userId) || empty($deskId) || empty($note) || empty($price) || empty($opinion)) {
            return new JsonResponse("Some data are empty! Check userId, deskId, note, price, opinion if empty", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userId = $usersRepository->findOneById($userId);
        $deskId = $desksRepository->findOneById($deskId);

        $booking->setUsers($userId)
                ->setDesks($deskId)
                ->setNote($note)
                ->setPrice($price)
                ->setOpinion($opinion)
                ->setStartDate(new \DateTime())
                ->setEndDate(new \DateTime())
                ->setCreated(new \DateTime());

        $entityManager->persist($booking);
        $entityManager->flush();

        return new JsonResponse(
            [
                'message' => "Booking is added",
            ], Response::HTTP_OK
        );

    }
}