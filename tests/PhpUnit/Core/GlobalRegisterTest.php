<?php
/**
 * GlobalRegisterTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Interfaces\MediatorInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class GlobalRegisterTest
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\GlobalRegister
 */
class GlobalRegisterTest extends TestCase
{

    /**
     * @var LoggerInterface
     */
    private $oldLogger;

    /**
     * @var ModuleRegisterInterface
     */
    private $oldModuleRegister;

    /**
     * @var MediatorInterface
     */
    private $oldMediator;

    /**
     * Some tests change states so record them before the test here.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oldLogger = $this->getStaticAttribute(GlobalRegister::class, 'logger');
        $this->oldModuleRegister = $this->getStaticAttribute(GlobalRegister::class, 'moduleRegister');
        $this->oldMediator = $this->getStaticAttribute(GlobalRegister::class, 'mediator');
    }

    /**
     * Put the system back into it's old state.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->setStaticAttribute(GlobalRegister::class, 'logger', $this->oldLogger);
        $this->setStaticAttribute(GlobalRegister::class, 'moduleRegister', $this->oldModuleRegister);
        $this->setStaticAttribute(GlobalRegister::class, 'mediator', $this->oldMediator);
    }

    /**
     * @covers ::getModuleRegister
     */
    public function testGetModuleRegister()
    {
        /** @var ModuleRegisterInterface|\PHPUnit_Framework_MockObject_MockObject $moduleRegister */
        $moduleRegister = $this->getMockForAbstractClass(ModuleRegisterInterface::class);
        $this->assertInstanceOf(
            ModuleRegisterInterface::class,
            GlobalRegister::getModuleRegister()
        );
        $this->assertNotSame(
            $moduleRegister,
            GlobalRegister::getModuleRegister()
        );

        $this->setStaticAttribute(GlobalRegister::class, 'moduleRegister', $moduleRegister);
        $this->assertInstanceOf(
            ModuleRegisterInterface::class,
            GlobalRegister::getModuleRegister()
        );
        $this->assertSame(
            $moduleRegister,
            GlobalRegister::getModuleRegister()
        );
    }

    /**
     * @covers ::setModuleRegister
     */
    public function testSetModuleRegister()
    {
        /** @var ModuleRegisterInterface|\PHPUnit_Framework_MockObject_MockObject $moduleRegister */
        $moduleRegister = $this->getMockForAbstractClass(ModuleRegisterInterface::class);

        $this->assertNotSame(
            $moduleRegister,
            $this->getStaticAttribute(GlobalRegister::class, 'moduleRegister')
        );

        GlobalRegister::setModuleRegister($moduleRegister);

        $this->assertSame(
            $moduleRegister,
            $this->getStaticAttribute(GlobalRegister::class, 'moduleRegister')
        );
    }

    /**
     * @covers ::setModuleRegister
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Module register can only be set once. Changing it would be non-deterministic.
     */
    public function testSetModuleRegisterException()
    {
        /** @var ModuleRegisterInterface|\PHPUnit_Framework_MockObject_MockObject $moduleRegister */
        $moduleRegister = $this->getMockForAbstractClass(ModuleRegisterInterface::class);
        GlobalRegister::setModuleRegister($moduleRegister);
        GlobalRegister::setModuleRegister($moduleRegister);
    }

    /**
     * @covers ::getLogger
     */
    public function testGetLogger()
    {
        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        $this->assertInstanceOf(
            LoggerInterface::class,
            GlobalRegister::getLogger()
        );
        $this->assertNotSame(
            $logger,
            GlobalRegister::getLogger()
        );
        $this->assertInstanceOf(
            NullLogger::class,
            GlobalRegister::getLogger()
        );

        $this->setStaticAttribute(GlobalRegister::class, 'logger', $logger);
        $this->assertInstanceOf(
            LoggerInterface::class,
            GlobalRegister::getLogger()
        );
        $this->assertSame(
            $logger,
            GlobalRegister::getLogger()
        );
    }

    /**
     * @covers ::setLogger
     */
    public function testSetLogger()
    {
        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        $this->assertNotSame(
            $logger,
            $this->getStaticAttribute(GlobalRegister::class, 'logger')
        );

        GlobalRegister::setLogger($logger);

        $this->assertSame(
            $logger,
            $this->getStaticAttribute(GlobalRegister::class, 'logger')
        );
    }

    /**
     * @covers ::setLogger
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Global logger can only be set once. Changing it would be non-deterministic.
     */
    public function testSetLoggerException()
    {
        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);
        GlobalRegister::setLogger($logger);
        GlobalRegister::setLogger($logger);
    }
}
