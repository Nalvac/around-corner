<?php

namespace App\Controller;

use App\Repository\BookingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[Route(path: 'api/status-desk/{id}', name: 'api_delete_status_desk', methods: ['DELETE'])]
    public function deleteOption(StatusDesksRepository $statusDesksRepository, string $id): JsonResponse
    {
        $status = $statusDesksRepository->findOneById($id);
        if (!$status) {
            throw new \Exception('Sorry, status does not exist', Response::HTTP_NOT_FOUND);
        }

        // Supprimer la référence de statut dans tous les bureaux associés
        $desks = $status->getDesks();
        foreach ($desks as $desk) {
            $desk->setStatusDesks(null);
        }

        $statusDesksRepository->remove($status,true);
        return new JsonResponse(
            [
                'message' => "Status is deleted",
            ], Response::HTTP_OK
        );
    }

    #[Route(path: 'api/status-desk/{id}', name: 'api_update_status_desk', methods: ['PUT'])]
    public function editOption(StatusDesksRepository $statusDesksRepository, Request $request, string $id): JsonResponse
    {
        $status = $statusDesksRepository->findOneById($id);
        if ($status == null) {
            throw new \Exception('Sorry, status does not exist', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );
        $name = $data["name"];

        if (!empty($name)) {
            $status->setName($name);
            $statusDesksRepository->save($status, true);
            return new JsonResponse(
                [
                    'message' => "Status is updated",
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse('Name of option is empty with no data',Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(path: 'api/status-desk', name: 'api_post_desk_status', methods: ['POST'])]
    public function addDeskStatut(StatusDesksRepository $statusDesksRepository, Request $request): JsonResponse
    {
        $statutDesk = new StatusDesks();
        $data = json_decode( $request->getContent(), true);
        $name = $data["name"];

        $checkIfDeskStatutExists = $statusDesksRepository->findOneBy(['name' => $name]);
        if ($checkIfDeskStatutExists) {
            return new JsonResponse("this statut desk already exist", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!empty($name)) {
            $statutDesk->setName($name);
            $statusDesksRepository->save($statutDesk, true);
            return new JsonResponse(
                [
                    'message' => "Statut is added",
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse('Name of statut is empty with no data',Response::HTTP_BAD_REQUEST);
        }
    }
}