<?php

namespace App\Controller;

use App\Exception\UserSaveException;
use App\Persister\UserPersister;
use App\Service\UserCreator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private UserCreator $userCreator;

    private UserPersister $userPersister;

    public function __construct(
        UserCreator $userCreator,
        UserPersister $userPersister
    ){
        $this->userCreator = $userCreator;
        $this->userPersister = $userPersister;
    }

    #[Route('/api/register', name: 'register', methods: ["POST"])]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {

        $decoded = json_decode($request->getContent());
        $email = $decoded->email;
        $plaintextPassword = $decoded->password;

        $user = $this->userCreator->getUserEntity($passwordHasher, $plaintextPassword, $email, $decoded);
        try {
            $this->userPersister->persist($user);
        } catch (UserSaveException $e) {
            $this->json(['message' => 'Registered failed', 401]);
        }

        return $this->json(['message' => 'Registered Successfully']);
    }
}
