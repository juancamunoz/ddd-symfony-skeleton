<?php

namespace App\Context\Auth\User\Application\SearchUser;

use App\Context\Auth\User\Domain\Repository\Criteria\SearchUserCriteria;
use App\Context\Auth\User\Domain\Repository\UserRepository;
use App\Context\Auth\User\Domain\User;

class SearchUserUseCase
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function __invoke(string $email): ?User
    {
        $users = $this->repository->findByCriteria(SearchUserCriteria::create($email));

        if (empty($users)) {
            return null;
        }

        return current($users);
    }
}
