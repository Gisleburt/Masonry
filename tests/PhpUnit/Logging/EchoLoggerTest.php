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

    /**
     * @test
     * @covers ::log
     */
    public function testLog()
    {
        $logLevel = 'test level';
        $logMessage = 'test message';
        $logContext = [];

        $testString = 'test string';

        /** @var EchoLogger|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger =
            $this
                ->getMockBuilder($this->getTestSubjectClass())
                ->setMethods(['formatLog'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('formatLog')
            ->with($logLevel, $logMessage)
            ->will($this->returnValue($testString));

        $this->expectOutputString($testString . PHP_EOL);

        $logger->log($logLevel, $logMessage, $logContext);
    }
}
