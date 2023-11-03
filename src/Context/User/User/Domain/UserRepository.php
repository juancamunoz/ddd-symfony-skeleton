<?php

namespace App\Context\User\User\Domain;

interface UserRepository
{
    public function save(User $user): void;
}
