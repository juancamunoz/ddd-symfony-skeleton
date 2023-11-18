<?php

namespace App\Context\Auth\User\Application\SearchUser;

use App\Context\Auth\User\Domain\User;
use App\SharedKernel\Domain\Aggregate\Exception\AggregateNotFoundException;
use App\SharedKernel\Domain\Bus\Query\QueryHandlerInterface;
use App\SharedKernel\Domain\Bus\Query\Response;

class SearchUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly SearchUserUseCase $useCase)
    {
    }

    public function __invoke(SearchUserQuery $query): Response
    {
        $user = $this->useCase->__invoke($query->email());

        if (null === $user) {
            throw AggregateNotFoundException::fromAggregate(User::class);
        }

        return new SearchUserResponse($user->id(), $user->email());
    }
}
