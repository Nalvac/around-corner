<?php

namespace App\Controller;

use App\Entity\StatusUsers;
use App\Repository\OptionsRepository;
use App\Repository\StatusUsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

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
            throw new \Exception('Sorry, status does not exist', Response::HTTP_NOT_FOUND);
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
        $status = $statusUsersRepository->findOneBy(['id' => $id]);
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
}