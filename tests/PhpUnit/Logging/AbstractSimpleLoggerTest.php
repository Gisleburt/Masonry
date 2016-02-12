<?php
/**
 * AbstractSimpleLoggerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Logging;

use Foundry\Masonry\Logging\AbstractSimpleLogger;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Psr\Log\LogLevel;

/**
 * Class AbstractSimpleLoggerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Logging\AbstractSimpleLogger
 */
abstract class AbstractSimpleLoggerTest extends TestCase
{

    /**
     * @return AbstractSimpleLogger
     */
    abstract protected function getTestSubjectClass();

    /**
     * @test
     * @covers ::formatLog
     */
    public function testFormatLog()
    {
        $logLevel = LogLevel::DEBUG;
        $logMessage = 'log message';

        $logger =
            $this
                ->getMockBuilder($this->getTestSubjectClass())
                ->setMethods(['formatLevel', 'formatMessage'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('formatLevel')
            ->with($logLevel)
            ->will($this->returnValue("$logLevel -"));
        $logger
            ->expects($this->once())
            ->method('formatMessage')
            ->with($logMessage)
            ->will($this->returnValue("- $logMessage"));

        $formatLog = $this->getObjectMethod($logger, 'formatLog');

        $this->assertSame(
            "$logLevel -- $logMessage",
            $formatLog($logLevel, $logMessage)
        );
    }

    /**
     * @test
     * @covers ::formatLevel
     */
    public function testFormatLevel()
    {
        $logLevel = LogLevel::DEBUG;

        $logger =
            $this
                ->getMockBuilder($this->getTestSubjectClass())
                ->setMethods(['translateLevel', 'decorateLevel', 'colorForLevel'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('translateLevel')
            ->with($logLevel)
            ->will($this->returnValue("Translated: $logLevel"));
        $logger
            ->expects($this->once())
            ->method('decorateLevel')
            ->with("Translated: $logLevel")
            ->will($this->returnValue("Decorated: Translated: $logLevel"));
        $logger
            ->expects($this->once())
            ->method('colorForLevel')
            ->with($logLevel, "Decorated: Translated: $logLevel")
            ->will($this->returnValue("Colored: Decorated: Translated: $logLevel"));

        $formatLevel = $this->getObjectMethod($logger, 'formatLevel');

        $this->assertSame(
            "Colored: Decorated: Translated: $logLevel",
            $formatLevel($logLevel)
        );
    }

    /**
     * @test
     * @covers ::translateLevel
     */
    public function testTranslateLevel()
    {
        $logLevel1 = LogLevel::DEBUG;
        $logLevel2 = LogLevel::ALERT;

        $loggerClass = $this->getTestSubjectClass();
        $logger = new $loggerClass();

        $translateLevel = $this->getObjectMethod($logger, 'translateLevel');

        $this->assertSame(
            'debug',
            $translateLevel($logLevel1)
        );
        $this->assertSame(
            'ALERT',
            $translateLevel($logLevel2)
        );
    }

    /**
     * @test
     * @covers ::decorateLevel
     */
    public function testDecorateLevel()
    {
        $logLevel1 = 'info';
        $logLevel2 = 'emergency';

        $loggerClass = $this->getTestSubjectClass();
        $logger = new $loggerClass();

        $decorateLevel = $this->getObjectMethod($logger, 'decorateLevel');

        $this->assertSame(
            'info   :  ',
            $decorateLevel($logLevel1)
        );
        $this->assertSame(
            'emergency :  ',
            $decorateLevel($logLevel2)
        );
    }

    /**
     * @test
     * @covers ::colorForLevel
     */
    public function testColorForLevel()
    {
        $logLevel = 'any level';
        $logMessage = 'any message';

        $loggerClass = $this->getTestSubjectClass();
        $logger = new $loggerClass();

        $colorForLevel = $this->getObjectMethod($logger, 'colorForLevel');

        $this->assertSame(
            $logMessage,
            $colorForLevel($logLevel, $logMessage)
        );
    }

    /**
     * @test
     * @covers ::formatMessage
     */
    public function testFormatMessage()
    {
        $logMessage = 'log message';

        $logger =
            $this
                ->getMockBuilder($this->getTestSubjectClass())
                ->setMethods(['decorateMessage'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('decorateMessage')
            ->with($logMessage)
            ->will($this->returnValue("Decorated Message: $logMessage"));

        $formatMessage = $this->getObjectMethod($logger, 'formatMessage');

        $this->assertSame(
            "Decorated Message: $logMessage",
            $formatMessage($logMessage)
        );
    }

    /**
     * @test
     * @covers ::decorateMessage
     */
    public function testDecorateMessage()
    {
        $logMessage = 'log message';

        $loggerClass = $this->getTestSubjectClass();
        $logger = new $loggerClass();

        $decorateMessage= $this->getObjectMethod($logger, 'decorateMessage');

        $this->assertSame(
            $logMessage,
            $decorateMessage($logMessage)
        );
    }
}
