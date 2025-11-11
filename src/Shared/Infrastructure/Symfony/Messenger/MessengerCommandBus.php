<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Messenger;

use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsAlias(CommandBusInterface::class)]
final class MessengerCommandBus implements CommandBusInterface
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus,
    ) {
        $this->messageBus = $queryBus;
    }

    /**
     * @template T
     *
     * @param CommandInterface<T> $command
     *
     * @return T
     */
    public function dispatch(CommandInterface $command): mixed
    {
        try {
            return $this->handle($command);
        } catch (HandlerFailedException $e) {
            $exceptions = $e->getWrappedExceptions();
            $exception = current($exceptions);

            if (false !== $exception) {
                throw $exception;
            }

            throw $e;
        }
    }
}
