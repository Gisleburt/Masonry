<?php
/**
 * HasLogger.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Logger;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * Trait HasLogger
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait HasLogger
{

    use LoggerAwareTrait;

    /**
     * Get the logger to be used for reporting
     * @return LoggerInterface
     */
    protected function getLogger()
    {
        return $this->logger;
    }
}
