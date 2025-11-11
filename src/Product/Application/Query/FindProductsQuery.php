<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<ProductRepositoryInterface>
 */
final readonly class FindProductsQuery implements QueryInterface
{
    public function __construct(
        public ?int $page = null,
        public ?int $itemsPerPage = null,
    ) {
    }
}
