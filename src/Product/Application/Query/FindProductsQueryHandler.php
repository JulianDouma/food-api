<?php

declare(strict_types=1);

namespace App\Product\Application\Query;

use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindProductsQueryHandler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {
    }

    public function __invoke(FindProductsQuery $query): ProductRepositoryInterface
    {
        $productRepository = $this->productRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $productRepository = $productRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $productRepository;
    }
}
