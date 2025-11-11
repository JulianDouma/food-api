<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\AbstractUid;
use Symfony\Component\Uid\Uuid;

trait AggregateRootId
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid', unique: true)]
    public readonly AbstractUid $value;

    public function __construct(?AbstractUid $value = null)
    {
        $this->value = $value ?? Uuid::v4();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
