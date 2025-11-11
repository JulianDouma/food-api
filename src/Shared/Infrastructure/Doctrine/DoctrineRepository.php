<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use App\Shared\Domain\Repository\PaginatorInterface;
use App\Shared\Domain\Repository\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Webmozart\Assert\Assert;

/**
 * @template T of object
 *
 * @implements RepositoryInterface<T>
 */
abstract class DoctrineRepository implements RepositoryInterface
{
    private ?int $page = null;
    private ?int $itemsPerPage = null;

    private QueryBuilder $queryBuilder;

    /**
     * @param class-string $entityClass
     */
    public function __construct(
        protected EntityManagerInterface $em,
        string $entityClass,
        string $alias,
    ) {
        $this->queryBuilder = $this->em->createQueryBuilder()
            ->select($alias)
            ->from($entityClass, $alias)
        ;
    }

    /**
     * @return \Iterator<array-key, T>
     */
    public function getIterator(): \Iterator
    {
        if (null !== $paginator = $this->paginator()) {
            yield from $paginator;

            return;
        }

        /** @var T[] $results */
        $results = $this->queryBuilder->getQuery()->getResult();

        yield from $results;
    }

    /**
     * @return ?PaginatorInterface<T>
     */
    public function paginator(): ?PaginatorInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        $firstResult = ($this->page - 1) * $this->itemsPerPage;
        $maxResults = $this->itemsPerPage;

        $repository = $this->filter(static function (QueryBuilder $qb) use ($firstResult, $maxResults): void {
            $qb->setFirstResult($firstResult)
                ->setMaxResults($maxResults)
            ;
        });

        /** @var Paginator<T> $paginator */
        $paginator = new Paginator($repository->queryBuilder->getQuery());

        return new DoctrinePaginator($paginator);
    }

    /**
     * @return DoctrineRepository<T>
     */
    public function filter(callable $filter): self
    {
        $cloned = clone $this;
        $filter($cloned->queryBuilder);

        return $cloned;
    }

    public function count(): int
    {
        $paginator = $this->paginator() ?? new Paginator(clone $this->queryBuilder);

        return \count($paginator);
    }

    public function query(): QueryBuilder
    {
        return clone $this->queryBuilder;
    }

    public function __clone(): void
    {
        $this->queryBuilder = clone $this->queryBuilder;
    }

    /**
     * @return static<T>
     */
    public function withoutPagination(): static
    {
        /** @var static<T> $cloned */
        $cloned = clone $this;
        $cloned->page = null;
        $cloned->itemsPerPage = null;

        return $cloned;
    }

    /**
     * @return static<T>
     */
    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        /** @var static<T> $cloned */
        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }
}
