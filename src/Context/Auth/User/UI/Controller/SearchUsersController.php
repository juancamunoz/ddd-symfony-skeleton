<?php

namespace App\Context\Auth\User\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Context\Auth\User\Application\SearchUser\SearchUsersUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchUsersController extends AbstractController
{
    public function __construct(private readonly SearchUsersUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $user = $this->useCase->__invoke($request->get('email'));

        if (null === $user) {
            throw new NotFoundHttpException('User not found');
        }

        return new JsonResponse($user);
    }
}
