<?php
/**
 * LoggerTrait.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command\Shared;

use Foundry\Masonry\Logging\MultiLogger;
use Foundry\Masonry\Logging\SymfonyOutputLogger;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Trait LoggerTrait
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait LoggerTrait
{
    /**
     * @param OutputInterface $output
     * @return MultiLogger
     */
    protected function setUpLogger(OutputInterface $output)
    {
        $logger = new MultiLogger();
        $logger->addLogger(
            new SymfonyOutputLogger($output)
        );
        return $logger;
    }
}
