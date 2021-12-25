<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\LevelSetList;
// use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    // $parameters->set(Option::PATHS, [__DIR__ . '/lib', __DIR__ . '/php']);

    $parameters->set(OPTION::AUTO_IMPORT_NAMES, true);
    $parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_80);
    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/vendor/autoload.php']);

    $parameters->set(Option::BOOTSTRAP_FILES, [
        __DIR__ . '/php/setup.php',
        __DIR__ . '/app/Helpers/helpers.php',
    ]);

    // Define what rule sets will be applied
    // $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(LevelSetList::UP_TO_PHP_80);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
