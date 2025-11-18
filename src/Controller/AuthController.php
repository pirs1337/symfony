<?php

namespace App\Controller;

use App\Presenter\RegisterPresenter;
use App\Request\RegisterRequest;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class AuthController extends AbstractController
{
    #[Route('/register', methods: ['POST'])]
    public function register(
        #[MapRequestPayload] RegisterRequest $request,
        UserService $userService,
        JWTTokenManagerInterface $jwtTokenManager,
        RegisterPresenter $presenter,
    ): JsonResponse
    {
        $user = $userService->create(
            email: $request->email,
            plainPassword: $request->password,
        );

        $token = $jwtTokenManager->create($user);

        $presentation = $presenter->create($user, $token);

        return $this->json(
            data: $presentation,
            status: Response::HTTP_CREATED,
            context: ['groups' => ['auth:register', 'user:read']],
        );
    }
}
