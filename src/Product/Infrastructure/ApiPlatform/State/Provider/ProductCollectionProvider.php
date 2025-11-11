<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindProductsQuery;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Infrastructure\ApiPlatform\State\Paginator;

/**
 * @implements ProviderInterface<ProductResource>
 */
final readonly class ProductCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $bus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return Paginator<ProductResource>|list<ProductResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Paginator|array
    {
        $page = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $page = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        $models = $this->bus->ask(new FindProductsQuery(
            page: $page,
            itemsPerPage: $limit,
        ));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = ProductResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                new \ArrayIterator($resources),
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
