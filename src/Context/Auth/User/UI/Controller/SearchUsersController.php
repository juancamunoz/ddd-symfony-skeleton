<?php

namespace App\Context\Auth\User\UI\Controller;

use App\Context\Auth\User\Application\SearchUser\SearchUserQuery;
use App\SharedKernel\Domain\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SearchUsersController extends AbstractController
{
    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->queryBus->ask(SearchUserQuery::create($request->get('email')));

        return new JsonResponse($response->result());
    }
}
