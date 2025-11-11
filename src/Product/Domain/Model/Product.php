<?php

declare(strict_types=1);

namespace App\Product\Domain\Model;

use App\Product\Domain\ValueObject\ProductId;
use App\Product\Domain\ValueObject\ProductName;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
readonly class Product
{
    #[ORM\Embedded(columnPrefix: false)]
    public private(set) ProductId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public private(set) ProductName $name,
    ) {
        $this->id = new ProductId();
    }
}
