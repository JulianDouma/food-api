<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\ApiPlatform\State\Provider\ProductCollectionProvider;
use App\Product\Infrastructure\ApiPlatform\State\Provider\ProductItemProvider;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Product',
    operations: [
        new GetCollection(
            uriTemplate: '/products',
            provider: ProductCollectionProvider::class,
        ),
        new Get(
            provider: ProductItemProvider::class
        ),
    ]
)]
final class ProductResource
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false, identifier: true)]
        public ?AbstractUid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'Default'])]
        public ?string $name = null,
    ) {
    }

    public static function fromModel(Product $model): self
    {
        return new self(
            id: $model->id->value,
            name: $model->name->value,
        );
    }
}
