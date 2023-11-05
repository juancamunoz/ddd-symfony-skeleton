<?php

namespace App\Context\Auth\User\Application\SearchUser;

use App\Context\Auth\User\Domain\Repository\Criteria\SearchUserCriteria;
use App\Context\Auth\User\Domain\Repository\UserRepository;

class SearchUsersUseCase
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function __invoke(string $email): ?array
    {
        $users = $this->repository->findByCriteria(SearchUserCriteria::create($email));

        if (empty($users)) {
            return null;
        }

        $user = current($users);

        return [
            'id' => $user->id(),
            'email' => $user->email()
        ];
    }
}
