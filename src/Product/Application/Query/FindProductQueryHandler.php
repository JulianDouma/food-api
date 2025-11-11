<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Exception\MissingProductException;
use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindProductQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository,
    ) {
    }

    public function __invoke(FindProductQuery $query): Product
    {
        $product = $this->repository->find($query->id);

        if (!$product instanceof Product) {
            throw new MissingProductException($query->id);
        }

        return $product;
    }
}
