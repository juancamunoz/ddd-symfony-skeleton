<?php

namespace App\Context\Auth\User\Domain\Repository;

use App\Context\Auth\User\Domain\Repository\Criteria\SearchUserCriteria;
use App\Context\Auth\User\Domain\User;

interface UserRepository
{
    public function findByCriteria(SearchUserCriteria $criteria): array;
    public function save(User $user): void;
}
