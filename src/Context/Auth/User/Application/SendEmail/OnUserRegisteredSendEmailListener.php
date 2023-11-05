<?php

namespace App\Context\Auth\User\Application\SendEmail;

use App\Context\Auth\User\Domain\Event\UserWasCreated;
use App\SharedKernel\Domain\Event\DomainEventListener;

class OnUserRegisteredSendEmailListener implements DomainEventListener
{
    public function __invoke(UserWasCreated $event): void
    {
        // Send email...
    }
}
