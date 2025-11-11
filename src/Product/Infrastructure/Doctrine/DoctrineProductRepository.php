<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Doctrine;

use App\Product\Domain\Model\Product;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Product\Domain\ValueObject\ProductId;
use App\Shared\Infrastructure\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

/**
 * @extends DoctrineRepository<Product>
 */
#[AsAlias(ProductRepositoryInterface::class)]
final class DoctrineProductRepository extends DoctrineRepository implements ProductRepositoryInterface
{
    private const string ENTITY_CLASS = Product::class;
    private const string ALIAS = 'product';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function find(ProductId $id): ?Product
    {
        $result = $this->em->find(self::ENTITY_CLASS, $id->value);

        return $result instanceof Product ? $result : null;
    }
}
