<?php
require_once 'vendor/autoload.php';

use Slim\App;

use Shangpinchacheng\Settings;
use Shangpinchacheng\Config;

session_start();

$app = new App(Settings::getSettings());

$config = new Config($app);
$config->setDependency();
$config->setAction();
$config->setRouter();

$app->run();
