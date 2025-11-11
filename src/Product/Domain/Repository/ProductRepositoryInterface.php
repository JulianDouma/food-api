<?php

declare(strict_types=1);

namespace App\Product\Domain\Repository;

use App\Product\Domain\Model\Product;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Product>
 */
interface ProductRepositoryInterface extends RepositoryInterface
{
    public function find(ProductId $id): ?Product;
}
