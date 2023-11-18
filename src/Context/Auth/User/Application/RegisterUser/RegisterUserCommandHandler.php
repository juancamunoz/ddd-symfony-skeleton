<?php

namespace App\Context\Auth\User\Application\RegisterUser;

use App\SharedKernel\Domain\Bus\Command\CommandHandlerInterface;

class RegisterUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly RegisterUserUseCase $useCase)
    {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $this->useCase->__invoke(
            $command->id(),
            $command->name()
        );
    }
}
