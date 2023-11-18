<?php

namespace App\Context\Auth\User\Application\SearchUser;

use App\SharedKernel\Domain\Bus\Query\Response;

class SearchUserResponse implements Response
{
    public function __construct(private readonly string $id, private readonly string $email)
    {
    }

    public function result(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }
}
