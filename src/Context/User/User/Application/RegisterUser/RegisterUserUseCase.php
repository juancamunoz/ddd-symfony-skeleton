<?php

namespace App\Context\User\User\Application\RegisterUser;

use App\Context\User\User\Domain\User;
use App\Context\User\User\Domain\UserRepository;
use App\SharedKernel\Domain\Bus\EventBus;

class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly EventBus $eventBus
    ) {
    }

    public function __invoke(string $id): void
    {
        $user = User::create($id);

        $this->repository->save($user);

        $this->eventBus->publish(...$user->pullEvents());
    }
}
