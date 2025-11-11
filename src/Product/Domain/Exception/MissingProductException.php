<?php

declare(strict_types=1);

namespace App\Product\Domain\Exception;

use App\Product\Domain\ValueObject\ProductId;

final class MissingProductException extends \RuntimeException
{
    public function __construct(ProductId $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct(\sprintf('Cannot find product with id %s', (string) $id), $code, $previous);
    }
}
