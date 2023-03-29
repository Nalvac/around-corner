<?php

namespace App\Controller;

use App\Entity\StatusUsers;
use App\Repository\StatusUsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserStatusController  extends AbstractController
{
    #[Route(path: 'api/status-user', name: 'api_status', methods: ['GET'])]
    public function options(StatusUsersRepository $statusUsersRepository): JsonResponse
    {
        $models = $statusUsersRepository->findAll();
        foreach ($models as $status) {
            $data[] = [
                'id' => $status->getId(),
                'name' => $status->getName()
            ];
        }

        return new JsonResponse($data,Response::HTTP_OK);
    }

    #[Route(path: 'api/status-user/{id}', name: 'api_delete_status', methods: ['DELETE'])]
    public function deleteOption(StatusUsersRepository $statusUsersRepository, string $id): JsonResponse
    {
        $status = $statusUsersRepository->findOneById($id);
        if (!$status) {
            return new JsonResponse('Sorry, status does not exist', Response::HTTP_NOT_FOUND);
        }

        // Supprimer la référence de statut dans tous les utilisateurs associés
        $users = $status->getUsers();
        foreach ($users as $user) {
            $user->setStatus(null);
        }

        $statusUsersRepository->remove($status,true);
        return new JsonResponse(
            [
                'message' => "Status is deleted",
            ], Response::HTTP_OK
        );
    }

    #[Route(path: 'api/status-user/{id}', name: 'api_update_status', methods: ['PUT'])]
    public function editOption(StatusUsersRepository $statusUsersRepository, Request $request, string $id): JsonResponse
    {
        $status = $statusUsersRepository->findOneById($id);
        if ($status == null) {
            return new JsonResponse('Sorry, status does not exist', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );
        $name = $data["name"];

        if (!empty($name)) {
            $status->setName($name);
            $statusUsersRepository->save($status, true);
            return new JsonResponse(
                [
                    'message' => "Status is updated",
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse('Name of option is empty with no data',Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(path: 'api/status-user', name: 'api_post_user_status', methods: ['POST'])]
    public function addUserStatut(StatusUsersRepository $statusUsersRepository, Request $request): JsonResponse
    {
        $option = new StatusUsers();
        $data = json_decode( $request->getContent(), true);
        $name = $data["name"];

        $checkIfUserStatutExists = $statusUsersRepository->findOneBy(['name' => $name]);
        if ($checkIfUserStatutExists) {
            return new JsonResponse("this statut user already exist", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!empty($name)) {
            $option->setName($name);
            $statusUsersRepository->save($option, true);
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