<?php

namespace App\SharedKernel\Infrastructure\Persistence\Doctrine;

use App\SharedKernel\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    protected EntityRepository $repository;

    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(static::entity());
    }

    public function doPersist(AggregateRoot $aggregate): void
    {
        $this->entityManager->persist($aggregate);
        $this->entityManager->flush();
    }

    abstract protected function entity(): string;
}
