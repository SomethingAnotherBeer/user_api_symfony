<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

use App\Service\UserService;
use App\Factory\DTOFactory;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private UserService $userService;
    private DTOFactory $dtoFactory;


    public function __construct(UserService $userService, DTOFactory $dtoFactory)
    {
        $this->userService = $userService;
        $this->dtoFactory = $dtoFactory;
    }

    #[Route('/api/users/{user_id}/info', methods: ['GET'], requirements: ['user_id' => '\d+'])]
    public function getUserInfo(int $user_id): JsonResponse
    {
        $response = $this->userService->getUserInfo($user_id);
        return $this->json($response)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    #[Route('/api/users/create', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $request_params = json_decode($request->getContent(), true);
        $dto = $this->dtoFactory->makeUserCreateDTO($request_params);

        $response = $this->userService->createUser($dto);

        return $this->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    #[Route('/api/users/{user_id}/change', methods: ['PATCH'], requirements: ['user_id' => '\d+'])]
    public function changeUser(Request $request, int $user_id): JsonResponse
    {
        $request_params = json_decode($request->getContent(), true);
        $dto = $this->dtoFactory->makeUserChangeDTO($request_params);

        $response = $this->userService->changeUser($user_id, $dto);

        return $this->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    #[Route('/api/users/{user_id}/delete', methods: ['DELETE'], requirements: ['user_id' => '\d+'])]
    public function deleteUser(int $user_id): JsonResponse
    {
        $response = $this->userService->deleteUser($user_id);
        return $this->json($response, 201)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }

    
}
