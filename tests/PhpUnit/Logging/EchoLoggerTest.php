<?php
/**
 * EchoLoggerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Logging;

use Foundry\Masonry\Logging\EchoLogger;

/**
 * Class EchoLoggerTest
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Logging\EchoLogger
 */
class EchoLoggerTest extends AbstractSimpleLoggerTest
{
    /**
     * @return EchoLogger
     */
    protected function getTestSubjectClass()
    {
        return EchoLogger::class;
    }
}
