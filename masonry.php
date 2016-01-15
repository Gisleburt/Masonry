#!/usr/bin/env php
<?php
/**
 * masonry.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


require __DIR__ . '/vendor/autoload.php';

use Foundry\Masonry\Core\Console\Command\Init;
use Foundry\Masonry\Core\Console\Command\Run;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Init());
$application->add(new Run());
$application->run();
