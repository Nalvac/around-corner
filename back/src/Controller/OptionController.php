<?php

namespace App\Controller;

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
    #[Route(path: 'api/option', name: 'api_options', methods: ['GET'])]
    public function options(OptionsRepository $optionsRepository, SerializerInterface $serializer): JsonResponse
    {
        $models = $optionsRepository->findAll();
        $data = $serializer->serialize($models, JsonEncoder::FORMAT);;
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route(path: 'api/option/{id}', name: 'api_delete_options', methods: ['DELETE'])]
    public function deleteOption(OptionsRepository $optionsRepository, string $id): JsonResponse
    {
        $option = $optionsRepository->findOneBy(['id' => $id]);
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

    #[Route(path: 'api/option/{id}', name: 'api_update_options', methods: ['PUT'])]
    public function editOption(OptionsRepository $optionsRepository, Request $request, string $id): JsonResponse
    {
        $option = $optionsRepository->findOneBy(['id' => $id]);
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
}