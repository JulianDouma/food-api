<?php

declare(strict_types=1);

return static function (Symfony\Config\DebugConfig $debug): void {
    $debug->dumpDestination('tcp://%env(VAR_DUMPER_SERVER)%');
};
