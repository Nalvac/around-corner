<?php

namespace App\Controller;

use App\Entity\Options;
use App\Repository\OptionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class OptionController extends AbstractController
{
    /**
     * Afficher toutes les options
     */
    #[Route(path: 'api/option', name: 'api_options', methods: ['GET'])]
    public function options(OptionsRepository $optionsRepository): JsonResponse
    {
        $models = $optionsRepository->findAll();
        if (!empty($models)) {
            foreach ($models as $option) {
                $tabDesk = [];
                foreach ($option->getDesks() as $desk) {
                    $tabDesk[] = $desk->getId();
                }
                $data[] = [
                    'id' => $option->getId(),
                    'name' => $option->getName(),
                    'desk' => $tabDesk,
                ];
            }

            return new JsonResponse($data,Response::HTTP_OK);
        } else {
            return new JsonResponse('Aucun option disponible',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Supprimer une option (pour l'admin)
     */
    #[Route(path: 'api/option/{id}', name: 'api_delete_options', methods: ['DELETE'])]
    public function deleteOption(OptionsRepository $optionsRepository, string $id): JsonResponse
    {
        $option = $optionsRepository->findOneById($id);
        if ($option == null) {
            throw new \Exception('Sorry, option does not exist', Response::HTTP_NOT_FOUND);
        }
        $optionsRepository->remove($option, true);
        return new JsonResponse(
            [
                'message' => "Option is deleted",
            ], Response::HTTP_OK
        );
    }

    /**
     * Mettre a jour une option (pour l'admin)
     */
    #[Route(path: 'api/option/{id}', name: 'api_update_options', methods: ['PUT'])]
    public function editOption(OptionsRepository $optionsRepository, Request $request, string $id): JsonResponse
    {
        $option = $optionsRepository->findOneById($id);;
        if ($option == null) {
            throw new \Exception('Sorry, option does not exist', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode(
            $request->getContent(),
            true
        );
        $name = $data["name"];

        if (!empty($name)) {
            $option->setName($name);
            $optionsRepository->save($option, true);
            return new JsonResponse(
                [
                    'message' => "Option is updated",
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse('Name of option is empty with no data',Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajouter une option (pour l'admin)
     */
    #[Route(path: 'api/option', name: 'api_update_options', methods: ['POST'])]
    public function addOption(OptionsRepository $optionsRepository, Request $request): JsonResponse
    {
        $option = new Options();

        $data = json_decode(
            $request->getContent(),
            true
        );
        $name = $data["name"];

        $checkIfOptionExists = $optionsRepository->findOneBy(['name'=>$name]);
        if ($checkIfOptionExists) {
            return new JsonResponse("Option already exists", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!empty($name)) {
            $option->setName($name);
            $optionsRepository->save($option, true);
            return new JsonResponse(
                [
                    'message' => "Option is added",
                ], Response::HTTP_OK
            );
        } else {
            return new JsonResponse('Name of option is empty with no data',Response::HTTP_BAD_REQUEST);
        }
    }
}