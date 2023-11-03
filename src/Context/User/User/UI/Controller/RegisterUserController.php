<?php

namespace App\Context\User\User\UI\Controller;

use App\Context\User\User\Application\RegisterUser\RegisterUserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends AbstractController
{
    public function __construct(private readonly RegisterUserUseCase $useCase)
    {
    }

    public function __invoke(string $id): Response
    {
        $this->useCase->__invoke($id);

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}
