<?php

namespace App\Tests\Unit\Auth\User\Application\RegisterUser;

use App\Context\Auth\User\Application\RegisterUser\RegisterUserUseCase;
use App\Context\Auth\User\Domain\Event\UserWasCreated;
use App\Context\Auth\User\Domain\Repository\UserRepository;
use App\Context\Auth\User\Domain\User;
use App\SharedKernel\Domain\Bus\Event\EventBus;
use App\Tests\Unit\SharedKernel\UnitTestCase;

class RegisterUserUseCaseTest extends UnitTestCase
{
    private const USER_ID = 'ce3d9456-dd0f-42df-b229-c0eac5925025';
    private const USER_EMAIL = 'test@test.com';

    public function test_it_register_a_new_user(): void
    {
        $repository = $this->createMock(UserRepository::class);
        $eventBus = $this->createMock(EventBus::class);

        $expectedUser = new User(self::USER_ID, self::USER_EMAIL);
        $repository
            ->method('save')
            ->with($this->similarTo($expectedUser));

        $eventBus
            ->expects(self::once())
            ->method('publish')
            ->with(UserWasCreated::create(self::USER_ID, self::USER_EMAIL));

        $useCase = new RegisterUserUseCase($repository, $eventBus);
        $useCase->__invoke(self::USER_ID, self::USER_EMAIL);
    }
}
