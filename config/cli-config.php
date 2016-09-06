<?php
require_once 'vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Shangpinchacheng\Settings;

$settings = Settings::getSettings();

$config = Setup::createAnnotationMetadataConfiguration(
    $settings['settings']['doctrine']['meta']['entity_path'],
    $settings['settings']['doctrine']['meta']['auto_generate_proxies'],
    $settings['settings']['doctrine']['meta']['proxy_dir'],
    $settings['settings']['doctrine']['meta']['cache'],
    false
);

$em = EntityManager::create($settings['settings']['doctrine']['connection'], $config);

return ConsoleRunner::createHelperSet($em);
