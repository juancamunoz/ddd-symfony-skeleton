<?php

namespace App\Context\Auth\User\Application\SearchUser;

use App\Context\Auth\Event\AuthQuery;

class SearchUserQuery extends AuthQuery
{
    private const EMAIL_KEY = 'email';

    public static function create(string $email): self
    {
        return new self([
            self::EMAIL_KEY => $email
        ]);
    }

    public function email(): string
    {
        return $this->get(self::EMAIL_KEY);
    }

    protected function messageName(): string
    {
        return 'user.search_user';
    }
}
