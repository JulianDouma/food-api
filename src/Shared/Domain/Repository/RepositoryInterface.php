<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<array-key, T>
 */
interface RepositoryInterface extends \Countable, \IteratorAggregate
{
    /**
     * @return \Iterator<T>
     */
    public function getIterator(): \Iterator;

    public function count(): int;

    /**
     * @return PaginatorInterface<T>|null
     */
    public function paginator(): ?PaginatorInterface;

    /**
     * @return static<T>
     */
    public function withPagination(int $page, int $itemsPerPage): self;

    /**
     * @return static<T>
     */
    public function withoutPagination(): self;
}
