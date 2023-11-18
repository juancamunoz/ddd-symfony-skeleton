<?php

namespace App\Context\Auth\User\Application\SendEmail;

use App\Context\Auth\User\Domain\Event\UserWasCreated;
use App\SharedKernel\Domain\Bus\Event\DomainEventListenerInterface;

class OnUserRegisteredSendEmailListener implements DomainEventListenerInterface
{
    public function __invoke(UserWasCreated $event): void
    {
        file_put_contents(__DIR__ . '/test.txt', json_encode($event->toArray()));
    }
}
