<?php

namespace App\Context\Auth\User\Application\RegisterUser;

use App\Context\Auth\User\Domain\Repository\UserRepository;
use App\Context\Auth\User\Domain\User;
use App\SharedKernel\Domain\Bus\EventBus;

class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventBus $eventBus
    ) {
    }

    public function __invoke(string $id, string $email): void
    {
        $user = User::create($id, $email);

        $this->repository->save($user);

        $this->eventBus->publish(...$user->pullDomainEvents());
    }
}
