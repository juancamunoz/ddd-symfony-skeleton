<?php

namespace App\Context\Auth\User\Infrastructure\Persistence\Doctrine;

use App\Context\Auth\User\Domain\Repository\Criteria\SearchUserCriteria;
use App\Context\Auth\User\Domain\Repository\UserRepository;
use App\Context\Auth\User\Domain\User;
use App\SharedKernel\Infrastructure\Persistence\Doctrine\DoctrineRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;

class MysqlDoctrineUserRepository extends DoctrineRepository implements UserRepository
{
    protected function entity(): string
    {
        return User::class;
    }

    public function findByCriteria(SearchUserCriteria $criteria): array
    {
        $where = 'WHERE 1';

        if ($criteria->hasEmail()) {
            $where .= ' AND email = :email';
        }

        $sql = <<<SQL
            SELECT id, email FROM users
            $where
        SQL;

        $query = $this->getNativeQuery($sql);

        if ($criteria->hasEmail()) {
            $query->setParameter('email', $criteria->email());
        }

        return $query->getResult();
    }

    public function save(User $user): void
    {
        $this->doPersist($user);
    }

    protected function getNativeQuery(string $sql): NativeQuery
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult(self::entity(), 'u');
        $rsm->addFieldResult('u', 'id', 'id');
        $rsm->addFieldResult('u', 'email', 'email');

        return $this->entityManager->createNativeQuery($sql, $rsm);
    }
}
