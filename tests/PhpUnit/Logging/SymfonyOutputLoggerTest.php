<?php
/**
 * SymfonyOutputLoggerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Logging;

use Foundry\Masonry\Interfaces\NotificationInterface;
use Foundry\Masonry\Logging\SymfonyOutputLogger;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SymfonyOutputLoggerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Logging\SymfonyOutputLogger
 */
class SymfonyOutputLoggerTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testConstruct()
    {
        $time1 = microtime(true);

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = new SymfonyOutputLogger($output);

        $this->assertSame(
            $output,
            $this->getObjectAttribute($logger, 'output')
        );

        $this->assertGreaterThanOrEqual(
            $time1,
            $this->getObjectAttribute($logger, 'startTime')
        );

        $time2 = microtime(true);

        $this->assertLessThanOrEqual(
            $time2,
            $this->getObjectAttribute($logger, 'startTime')
        );
    }

    /**
     * @test
     * @covers ::getOutput
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testGetOutput()
    {
        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $logger = new SymfonyOutputLogger($output);

        $getOutput = $this->getObjectMethod($logger, 'getOutput');
        $this->assertSame(
            $output,
            $getOutput()
        );
    }

    /**
     * @test
     * @covers ::decorateLevel
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getTimeElapsed
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::decorateTimeElapsed
     * @uses \Foundry\Masonry\Logging\AbstractSimpleLogger::decorateLevel
     */
    public function testDecorateLevel()
    {
        $logLevel1 = 'info';
        $logLevel2 = 'emergency';

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->at(0))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_NORMAL));
        $output
            ->expects($this->at(1))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_DEBUG));

        $logger = new SymfonyOutputLogger($output);

        $decorateLevel = $this->getObjectMethod($logger, 'decorateLevel');

        $this->assertSame(
            'info    :  ',
            $decorateLevel($logLevel1)
        );

        $this->assertRegExp(
            '/\[\s+[\d\.]+s \] emergency :  /',
            $decorateLevel($logLevel2)
        );
    }

    /**
     * @test
     * @covers ::getMicroTime
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     */
    public function testGetMicroTime()
    {
        $startTime = microtime(true);

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = new SymfonyOutputLogger($output);
        $getMicroTime = $this->getObjectMethod($logger, 'getMicroTime');
        $microTime = $getMicroTime();

        $this->assertGreaterThanOrEqual(
            $startTime,
            $microTime
        );

        $endTime = microtime(true);

        $this->assertLessThanOrEqual(
            $endTime,
            $microTime
        );
    }

    /**
     * @test
     * @covers ::getTimeElapsed
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testGetTimeElapsed()
    {
        $startTime = 0.1;
        $microTime = 0.55555; // Not actually a microtime but valuable for the test

        $logger =
            $this
                ->getMockBuilder(SymfonyOutputLogger::class)
                ->disableOriginalConstructor()
                ->setMethods(['getMicroTime'])
                ->getMock();
        $logger
            ->expects($this->exactly(2))
            ->method('getMicroTime')
            ->with()
            ->will($this->returnValue($microTime));

        $this->setObjectAttribute($logger, 'startTime', $startTime);

        $getGetTimeElapsed = $this->getObjectMethod($logger, 'getTimeElapsed');

        // The result of the equation is 0.45555 which will round to 0 with precision 0
        $this->assertEquals(
            0,
            $getGetTimeElapsed(0)
        );

        // Default precision however will be rounded to 0.456
        $this->assertEquals(
            0.456,
            $getGetTimeElapsed()
        );
    }

    /**
     * @test
     * @covers ::decorateTimeElapsed
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testDecorateTimeElapsed()
    {
        $tooShort = 1;
        $tooLong = 11111.111111;
        $padding = 20;

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = new SymfonyOutputLogger($output);

        $this->setObjectAttribute($logger, 'startTime', $startTime);

        $decorateTimeElapsedElapsed = $this->getObjectMethod($logger, 'decorateTimeElapsed');

        $this->assertSame(
            '   1.000',
            $decorateTimeElapsedElapsed($tooShort)
        );
        $this->assertSame(
            '11111.111',
            $decorateTimeElapsedElapsed($tooLong)
        );
        $this->assertSame(
            '           11111.111',
            $decorateTimeElapsedElapsed($tooLong, $padding)
        );
    }

    /**
     * @test
     * @covers ::log
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testLogNotification()
    {
        $level = LogLevel::INFO;
        $formattedMessage = 'Formatted Message';

        /** @var NotificationInterface|\PHPUnit_Framework_MockObject_MockObject $notification */
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);

        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->at(0))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_NORMAL));
        $output
            ->expects($this->at(1))
            ->method('setVerbosity')
            ->with(OutputInterface::VERBOSITY_DEBUG);
        $output
            ->expects($this->at(2))
            ->method('writeln')
            ->with($formattedMessage);
        $output
            ->expects($this->at(3))
            ->method('setVerbosity')
            ->with(OutputInterface::VERBOSITY_NORMAL);

        /** @var SymfonyOutputLogger|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger =
            $this
                ->getMockBuilder(SymfonyOutputLogger::class)
                ->disableOriginalConstructor()
                ->setMethods(['formatLog', 'shouldNotificationOutput', 'getOutput'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('formatLog')
            ->with($level, $notification)
            ->will($this->returnValue($formattedMessage));
        $logger
            ->expects($this->once())
            ->method('shouldNotificationOutput')
            ->with($this->isInstanceOf(NotificationInterface::class), $output)
            ->will($this->returnValue(true));
        $logger
            ->expects($this->any())
            ->method('getOutput')
            ->with()
            ->will($this->returnValue($output));

        $logger->log($level, $notification, []);
    }

    /**
     * @test
     * @covers ::log
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     * @uses \Foundry\Masonry\Core\Notification
     */
    public function testLogString()
    {
        $level = LogLevel::INFO;
        $message = 'Test Message';
        $formattedMessage = 'Formatted Message';


        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->at(0))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_QUIET));
        $output
            ->expects($this->at(1))
            ->method('setVerbosity')
            ->with(OutputInterface::VERBOSITY_DEBUG);
        $output
            ->expects($this->at(2))
            ->method('writeln')
            ->with($formattedMessage);
        $output
            ->expects($this->at(3))
            ->method('setVerbosity')
            ->with(OutputInterface::VERBOSITY_QUIET);

        /** @var SymfonyOutputLogger|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger =
            $this
                ->getMockBuilder(SymfonyOutputLogger::class)
                ->disableOriginalConstructor()
                ->setMethods(['formatLog', 'shouldNotificationOutput', 'getOutput'])
                ->getMock();
        $logger
            ->expects($this->once())
            ->method('formatLog')
            ->with($level, $this->isInstanceOf(NotificationInterface::class))
            ->will($this->returnValue($formattedMessage));
        $logger
            ->expects($this->once())
            ->method('shouldNotificationOutput')
            ->with($this->isInstanceOf(NotificationInterface::class), $output)
            ->will($this->returnValue(true));
        $logger
            ->expects($this->any())
            ->method('getOutput')
            ->with()
            ->will($this->returnValue($output));

        $logger->log($level, $message, []);
    }

    /**
     * @test
     * @covers ::log
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testLogNoLog()
    {
        $level = LogLevel::INFO;

        /** @var NotificationInterface|\PHPUnit_Framework_MockObject_MockObject $notification */
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);


        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->once())
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_QUIET));
        $output
            ->expects($this->never())
            ->method('setVerbosity');
        $output
            ->expects($this->never())
            ->method('writeln');

        /** @var SymfonyOutputLogger|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger =
            $this
                ->getMockBuilder(SymfonyOutputLogger::class)
                ->disableOriginalConstructor()
                ->setMethods(['formatLog', 'shouldNotificationOutput', 'getOutput'])
                ->getMock();
        $logger
            ->expects($this->never())
            ->method('formatLog');
        $logger
            ->expects($this->once())
            ->method('shouldNotificationOutput')
            ->with($this->isInstanceOf(NotificationInterface::class), $output)
            ->will($this->returnValue(false));
        $logger
            ->expects($this->any())
            ->method('getOutput')
            ->with()
            ->will($this->returnValue($output));

        $logger->log($level, $notification, []);
    }

    /**
     * @test
     * @covers ::shouldNotificationOutput
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testShouldNotificationOutput()
    {
        // Set up
        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $logger = new SymfonyOutputLogger($output);
        $shouldNotificationOutput = $this->getObjectMethod($logger, 'shouldNotificationOutput');

        // Test a few combinations that should output

        $outputPriorities = [
            NotificationInterface::PRIORITY_NORMAL,
            NotificationInterface::PRIORITY_INFO,
            NotificationInterface::PRIORITY_DEBUG,
        ];

        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->exactly(count($outputPriorities)))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_VERY_VERBOSE));
        foreach ($outputPriorities as $priority) {
            $notification = $this->getMockForAbstractClass(NotificationInterface::class);
            $notification
                ->expects($this->exactly(2))
                ->method('getPriority')
                ->with()
                ->will($this->returnValue($priority));
            $this->assertTrue($shouldNotificationOutput($notification, $output));
        }

        // Test a few combinations that should NOT output

        $suppressedPriorities = [
            NotificationInterface::PRIORITY_NORMAL,
            NotificationInterface::PRIORITY_INFO,
            NotificationInterface::PRIORITY_DEBUG,
        ];

        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->exactly(count($suppressedPriorities)))
            ->method('getVerbosity')
            ->with()
            ->will($this->returnValue(OutputInterface::VERBOSITY_QUIET));
        foreach ($suppressedPriorities as $priority) {
            $notification = $this->getMockForAbstractClass(NotificationInterface::class);
            $notification
                ->expects($this->exactly(2))
                ->method('getPriority')
                ->with()
                ->will($this->returnValue($priority));
            $this->assertFalse($shouldNotificationOutput($notification, $output));
        }
    }

    /**
     * @test
     * @covers ::shouldNotificationOutput
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     * @expectedException \OutOfBoundsException
     * @expectedExceptionMessage Invalid Notification priority
     */
    public function testShouldNotificationOutputException()
    {
        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->never())
            ->method('getVerbosity');
        $notification = $this->getMockForAbstractClass(NotificationInterface::class);
        $notification
            ->expects($this->once())
            ->method('getPriority')
            ->with()
            ->will($this->returnValue(10000000000));

        $logger = new SymfonyOutputLogger($output);
        $shouldNotificationOutput = $this->getObjectMethod($logger, 'shouldNotificationOutput');

        $shouldNotificationOutput($notification, $output);
    }

    /**
     * @test
     * @covers ::colorForLevel
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testColorForLevel()
    {
        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $input = 'Test text';
        $levels = [
            LogLevel::NOTICE => "<fg=yellow>$input</>",
            LogLevel::INFO => "<fg=green>$input</>",
            LogLevel::DEBUG => "<fg=cyan>$input</>",
            LogLevel::EMERGENCY => "<fg=red>$input</>",
            LogLevel::ALERT => "<fg=red>$input</>",
            LogLevel::CRITICAL => "<fg=red>$input</>",
            LogLevel::ERROR => "<fg=red>$input</>",
            LogLevel::WARNING => "<fg=red>$input</>",
        ];

        $logger = new SymfonyOutputLogger($output);

        $colorForLevel = $this->getObjectMethod($logger, 'colorForLevel');

        foreach ($levels as $level => $output) {
            $this->assertSame(
                $output,
                $colorForLevel($level, $input)
            );
        }
    }

    /**
     * @test
     * @covers ::translateLevel
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::__construct
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger::getMicroTime
     */
    public function testTranslateLevel()
    {
        /** @var OutputInterface|\PHPUnit_Framework_MockObject_MockObject $output */
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $levels = [
            LogLevel::INFO => 'Success',
            LogLevel::ERROR => 'Failure',
            LogLevel::NOTICE => 'Notice',
            LogLevel::DEBUG => 'Debug',
            LogLevel::EMERGENCY => 'EMERGENCY',
            LogLevel::ALERT => 'ALERT',
            LogLevel::CRITICAL => 'CRITICAL',
            LogLevel::WARNING => 'WARNING',
        ];

        $logger = new SymfonyOutputLogger($output);

        $translateLevel = $this->getObjectMethod($logger, 'translateLevel');

        foreach ($levels as $level => $output) {
            $this->assertSame(
                $output,
                $translateLevel($level)
            );
        }
    }
}
