<?php

namespace App\Context\User\User\Application\SendEmail;

use App\Context\User\User\Domain\UserWasCreated;
use App\SharedKernel\Domain\Event\DomainEventListener;

class OnUserRegisteredSendEmailListener implements DomainEventListener
{
    public function __invoke(UserWasCreated $event): void
    {
    }
}
