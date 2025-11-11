<?php

declare(strict_types=1);

namespace App\Product\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final readonly class ProductName
{
    public function __construct(
        #[ORM\Column(name: 'name', length: 255)]
        public private(set) string $value,
    ) {
        Assert::lengthBetween($value, min: 1, max: 255);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
