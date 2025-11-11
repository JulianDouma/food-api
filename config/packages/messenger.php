<?php

declare(strict_types=1);

use App\Shared\Application\Command\CommandInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
    $framework->messenger()->defaultBus('command.bus');

    $commandBus = $framework->messenger()->bus('command.bus');
    $commandBus->middleware()->id('doctrine_transaction');

    $framework->messenger()->bus('query.bus');

    $framework->messenger()
        ->transport('sync')
        ->dsn('sync://')
    ;

    $framework->messenger()
        ->routing(QueryInterface::class)->senders(['sync'])
    ;
    $framework->messenger()
        ->routing(CommandInterface::class)->senders(['sync'])
    ;
};
