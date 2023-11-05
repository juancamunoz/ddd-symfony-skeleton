<?php

namespace App\Context\Auth\User\UI\Controller;

use App\Context\Auth\User\Application\RegisterUser\RegisterUserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends AbstractController
{
    public function __construct(private readonly RegisterUserUseCase $useCase)
    {
    }

    public function __invoke(Request $request, string $id): Response
    {
        $this->useCase->__invoke($id, $request->get('email'));

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}
