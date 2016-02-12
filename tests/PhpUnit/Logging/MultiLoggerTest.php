<?php
/**
 * MultiLoggerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Logging;

use Foundry\Masonry\Logging\MultiLogger;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class MultiLoggerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Logging\MultiLogger
 */
class MultiLoggerTest extends TestCase
{
    /**
     * @test
     * @covers ::addLogger
     */
    public function testAddLogger()
    {
        $multiLogger = new MultiLogger();
        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        $this->assertEmpty(
            $this->getObjectAttribute($multiLogger, 'loggers')
        );

        $this->assertSame(
            $multiLogger,
            $multiLogger->addLogger($logger)
        );

        $this->assertSame(
            [$logger],
            $this->getObjectAttribute($multiLogger, 'loggers')
        );
    }

    /**
     * @test
     * @covers ::log
     * @uses \Foundry\Masonry\Logging\MultiLogger::addLogger
     */
    public function testLog()
    {
        $logLevel = 'log level';
        $logMessage = 'log message';
        $logContext = [];

        $multiLogger = new MultiLogger();
        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        $logger
            ->expects($this->exactly(2))
            ->method('log')
            ->with($logLevel, $logMessage, $logContext);

        $multiLogger->addLogger($logger);
        $multiLogger->addLogger($logger);

        $multiLogger->log($logLevel, $logMessage, $logContext);
    }
}
