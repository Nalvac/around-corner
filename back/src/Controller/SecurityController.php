<?php
namespace App\Controller;

use App\Entity\Users;
use App\Repository\StatusUsersRepository;
use App\Repository\UsersRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route(path: 'api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        $user = $this->getUser();
        return new JsonResponse(
            [
                'username' => $user->getUserIdentifier(),
                'roles' => $user->getRoles()
            ], Response::HTTP_ACCEPTED
        );
    }

    #[Route(path: 'api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $encoder, UsersRepository $userRepository, StatusUsersRepository $statusUsersRepository): JsonResponse
    {
        //get data from body
        $data = json_decode(
            $request->getContent(),
            true
        );

        $email = $data['email'];
        $password = $data['password'];
        $roles = (array) $data['roles'];
        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $gender = $data['gender'];
        $nationality = $data['nationality'];
        $birthDate = $data['birthDate'];
        $adress = $data['adress'];
        $zipCode = $data['zipCode'];
        $city = $data['city'];
        $phoneNumber = $data['phoneNumber'];
        $image = $data['image'];

        if (empty($firstName) || empty($lastName) || empty($gender) || empty($nationality) || empty($adress) || empty($zipCode) || empty($city) || empty($phoneNumber) ||  empty($image)) {
            return new JsonResponse("Some data are empty! Check firstName, lastName, gender, nationality, statusUsersId, zipCode, city, phoneNumber, image if empty", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (empty($password) || empty($email)) {
            return new JsonResponse("Invalid Username or Password or Email", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $checkIfUserExists = $userRepository->findOneBy(['email' => $email]);
        if ($checkIfUserExists) {
            return new JsonResponse("Email already exists", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $statusUsersId = $data['statusUsersId'];
        $statusUsersId = $statusUsersRepository->find($statusUsersId);

        $user = new Users();
        $user
            ->setPassword($encoder->hashPassword($user, $password))
            ->setEmail($email)
            ->setRoles($roles)
            ->setBirthDate($birthDate)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setStatus($statusUsersId)
            ->setNationality($nationality)
            ->setGender($gender)
            ->setIsCertified(false)
            ->setAdress($adress)
            ->setZipCode($zipCode)
            ->setCity($city)
            ->setphoneNumber($phoneNumber)
            ->setImage($image)
            ->setAccess(new \DateTime())
            ->setCreated(new \DateTime());

        $userRepository->save($user, true);

        return new JsonResponse(sprintf('User %s successfully created', $user->getUserIdentifier()), Response::HTTP_OK);
    }

    #[Route(path: 'api/user', name: 'api_delete', methods: ['DELETE'])]
    public function deleteUser(UsersRepository $userRepository, Request $request): JsonResponse
    {
        $email = json_decode($request->getContent())->email;
        $user = $userRepository->findOneBy(['email' => $email]);
        if ($user == null) {
            return new JsonResponse('Sorry, User does not exist', Response::HTTP_NOT_FOUND);
        }
        $userRepository->remove($user, true);
        return new JsonResponse(
            [
                'message' => "User is deleted",
            ], 200
        );
    }

    #[Route(path: 'api/user/{userId}/certified', name: 'api_user_edit_certified', methods: ['PATCH'])]
    public function editIsCertified(UsersRepository $userRepository, Request $request, string $userId): JsonResponse
    {
        $isCertified = json_decode($request->getContent())->isCertified;
        if (empty($userId)) {
            return new JsonResponse(
                [
                    'message' => "Merci, de nous transmettre le user Id",
                ], 200
            );
        } else {
            if ($isCertified === "false") {
                return new JsonResponse("Invalid, User has to be certified", Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $user = $userRepository->findOneById($userId);
            $user->setIsCertified((bool) $isCertified);
            $userRepository->save($user,true);
        }
        return new JsonResponse(
            [
                'message' => "Merci, user est maintenant certifié",
            ], 200
        );
    }

    #[Route(path: 'api/logout', name: 'api_logout', methods: ['GET'])]
    public function logout(): JsonResponse
    {
        return new JsonResponse(
            [
                'message' => "Merci, à bientôt",
            ], 200
        );
    }

    #[Route('/api/user/{user_id}', name: 'app_user_edit', methods: ['PATCH'])]
    public function desk_edit(string $user_id, UsersRepository $usersRepository, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $usersRepository->findOneById($user_id);

        $user->setFirstName($data['firstName'] ?? $user->getFirstName());
        $user->setFirstName($data['lastName'] ?? $user->getLastName());
        $user->setFirstName($data['gender'] ?? $user->getGender());
        $user->setFirstName($data['email'] ?? $user->getEmail());
        $user->setFirstName($data['password'] ?? $user->getPassword());
        $user->setFirstName($data['roles'] ?? $user->getRoles());
        $user->setFirstName($data['gender'] ?? $user->getGender());
        $user->setFirstName($data['nationality'] ?? $user->getNationality());
        $user->setFirstName($data['birthDate'] ?? $user->getBirthDate());
        $user->setFirstName($data['adress'] ?? $user->getAdress());
        $user->setFirstName($data['zipCode'] ?? $user->getZipCode());
        $user->setFirstName($data['phoneNumber'] ?? $user->getPhoneNumber());
        $user->setFirstName($data['image'] ?? $user->getImage());

        $usersRepository->save($user, true);

        return new JsonResponse(['message' => 'User is updated'], Response::HTTP_OK);
    }

}