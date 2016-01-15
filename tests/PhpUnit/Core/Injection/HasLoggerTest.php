<?php
/**
 * HasLoggerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core\Injection;

use Foundry\Masonry\Core\Injection\HasLogger;
use Foundry\Masonry\Tests\PhpUnit\TestCaseTrait;
use Psr\Log\LoggerInterface;

/**
 * Trait HasLoggerTest
 * Test for HasLogger
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Injection\HasLogger
 */
trait HasLoggerTest
{
    use TestCaseTrait;

    /**
     * @return HasLogger
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getLogger
     * @uses \Foundry\Masonry\Core\Injection\HasLogger::setLogger
     */
    public function testGetLogger()
    {
        $testSubject = $this->getTestSubject();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        $getLogger = $this->getObjectMethod($testSubject, 'getLogger');

        $this->assertInstanceOf(
            LoggerInterface::class,
            $getLogger()
        );

        $this->assertNotSame(
            $logger,
            $getLogger()
        );

        $testSubject->setLogger($logger);

        $this->assertSame(
            $logger,
            $getLogger()
        );
    }

    /**
     * @test
     * @covers ::setLogger
     */
    public function testSetLogger()
    {
        /** @var HasLogger $testSubject */
        $testSubject = $this->getTestSubject();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        $this->assertNull(
            $this->getObjectAttribute($testSubject, 'logger')
        );

        $this->assertSame(
            $testSubject,
            $testSubject->setLogger($logger)
        );

        $this->assertSame(
            $logger,
            $this->getObjectAttribute($testSubject, 'logger')
        );
    }
}
