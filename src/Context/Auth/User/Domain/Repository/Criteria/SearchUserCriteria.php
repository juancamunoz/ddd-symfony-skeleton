<?php

namespace App\Context\Auth\User\Domain\Repository\Criteria;

class SearchUserCriteria
{
    private function __construct(private readonly string $email)
    {
    }

    public static function create(string $email): self
    {
        return new self($email);
    }

    public function email(): string
    {
        return $this->email;
    }
}
