<?php

declare(strict_types=1);

return static function (Symfony\Config\ApiPlatformConfig $apiPlatform): void {
    // region API Platform
    $apiPlatform
         ->title('Food API')
         ->version('experimental')
         ->defaults()
         ->stateless(true)
         ->cacheHeaders([
             'vary' => [
                 'Content-Type',
                 'Authorization',
                 'Origin',
             ],
         ]);
    // endregion

    // region Mapping
    $apiPlatform->mapping()
        ->paths(['%kernel.project_dir%/src/Product/Infrastructure/ApiPlatform/Resource/'])
    ;
    // endregion

    // region Formats
    $apiPlatform->formats('json')
        ->mimeTypes(['application/json']);
    // endregion

    // region Patch Formats
    $apiPlatform->patchFormats('json')
        ->mimeTypes(['application/merge-patch+json']);
    // endregion

    // region Error Formats
    $apiPlatform->errorFormats('json')
        ->mimeTypes(['application/problem+json']);
    // endregion
};
