<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Product\Application\Query\FindProductQuery;
use App\Product\Domain\ValueObject\ProductId;
use App\Product\Infrastructure\ApiPlatform\Resource\ProductResource;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @implements ProviderInterface<ProductResource>
 */
final readonly class ProductItemProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $bus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ProductResource
    {
        /** @var string $id */
        $id = $uriVariables['id'];

        $model = $this->bus->ask(new FindProductQuery(new ProductId(Uuid::fromString($id))));

        return ProductResource::fromModel($model);
    }
}
