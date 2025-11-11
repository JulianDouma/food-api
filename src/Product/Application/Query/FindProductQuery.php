<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Application\Query\QueryInterface;

/**
 * @implements QueryInterface<Product>
 */
final readonly class FindProductQuery implements QueryInterface
{
    public function __construct(
        public ProductId $id,
    ) {
    }
}
