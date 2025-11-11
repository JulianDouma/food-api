<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<array-key, T>
 */
interface PaginatorInterface extends \Countable, \IteratorAggregate
{
    public function getCurrentPage(): int;

    public function getItemsPerPage(): int;

    public function getLastPage(): int;

    public function getTotalItems(): int;
}
