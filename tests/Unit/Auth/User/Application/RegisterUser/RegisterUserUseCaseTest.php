<?php

namespace App\Tests\Unit\Auth\User\Application\RegisterUser;

use App\Context\Auth\User\Application\RegisterUser\RegisterUserUseCase;
use App\Context\Auth\User\Domain\Event\UserWasCreated;
use App\Context\Auth\User\Domain\Repository\UserRepository;
use App\SharedKernel\Domain\Bus\Event\EventBus;
use App\Tests\Unit\Auth\User\Domain\UserMother;
use App\Tests\Unit\SharedKernel\UnitTestCase;

class RegisterUserUseCaseTest extends UnitTestCase
{
    public function test_it_register_a_new_user(): void
    {
        $repository = $this->createMock(UserRepository::class);
        $eventBus = $this->createMock(EventBus::class);

        $expectedUser = UserMother::default();
        $repository
            ->method('save')
            ->with($this->similarTo($expectedUser));

        $eventBus
            ->expects(self::once())
            ->method('publish')
            ->with(UserWasCreated::create($expectedUser->id(), $expectedUser->email()));

        $useCase = new RegisterUserUseCase($repository, $eventBus);
        $useCase->__invoke($expectedUser->id(), $expectedUser->email());
    }
}
