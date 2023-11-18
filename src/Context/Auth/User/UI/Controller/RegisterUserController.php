<?php

namespace App\Context\Auth\User\UI\Controller;

use App\Context\Auth\User\Application\RegisterUser\RegisterUserCommand;
use App\SharedKernel\Domain\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends AbstractController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(Request $request, string $id): Response
    {
        $this->commandBus->dispatch(RegisterUserCommand::create($id, $request->get('email')));

        return new JsonResponse(['id' => $id], Response::HTTP_CREATED);
    }
}
