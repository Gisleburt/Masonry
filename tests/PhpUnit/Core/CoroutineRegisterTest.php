<?php
/**
 * CoroutineRegisterTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Coroutine;
use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\CoroutineRegister;


/**
 * Class CoroutineRegisterTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\CoroutineRegister
 */
class CoroutineRegisterTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstructDefault()
    {
        $coroutineRegister = new CoroutineRegister();

        $this->assertSame(
            100,
            $this->getObjectAttribute($coroutineRegister, 'sleepTime')
        );

        $this->assertTrue(
            is_array($this->getObjectAttribute($coroutineRegister, 'coroutines'))
        );

        $this->assertEmpty(
            $this->getObjectAttribute($coroutineRegister, 'coroutines')
        );
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstructSleepTime()
    {
        $sleepTime = 999;
        $coroutineRegister = new CoroutineRegister($sleepTime);

        $this->assertSame(
            $sleepTime,
            $this->getObjectAttribute($coroutineRegister, 'sleepTime')
        );

        $this->assertTrue(
            is_array($this->getObjectAttribute($coroutineRegister, 'coroutines'))
        );

        $this->assertEmpty(
            $this->getObjectAttribute($coroutineRegister, 'coroutines')
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage sleepTime must be an integer
     */
    public function testConstructException()
    {
        new CoroutineRegister('not an integer');
    }

    /**
     * @test
     * @covers ::register
     * @uses \Foundry\Masonry\Core\CoroutineRegister::__construct
     */
    public function testRegisterValid()
    {
        /** @var CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject $coroutine */
        $coroutine = $this->getMockForAbstractClass(CoroutineInterface::class);
        $coroutine
            ->expects($this->once())
            ->method('isValid')
            ->with()
            ->will($this->returnValue(true));

        $coroutineRegister = new CoroutineRegister();
        $coroutineRegister->register($coroutine);

        $this->assertContainsOnly(
            $coroutine,
            $this->getObjectAttribute($coroutineRegister, 'coroutines')
        );
    }

    /**
     * @test
     * @covers ::isValid
     * @uses \Foundry\Masonry\Core\CoroutineRegister::__construct
     * @uses \Foundry\Masonry\Core\CoroutineRegister::register
     */
    public function testRegisterInvalid()
    {
        /** @var CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject $coroutine */
        $coroutine = $this->getMockForAbstractClass(CoroutineInterface::class);
        $coroutine
            ->expects($this->once())
            ->method('isValid')
            ->with()
            ->will($this->returnValue(true));

        $coroutineRegister = new CoroutineRegister();

        $this->assertFalse(
            $coroutineRegister->isValid()
        );

        $coroutineRegister->register($coroutine);

        $this->assertTrue(
            $coroutineRegister->isValid()
        );
    }

    /**
     * @test
     * @covers ::tick
     * @uses \Foundry\Masonry\Core\CoroutineRegister::__construct
     * @uses \Foundry\Masonry\Core\CoroutineRegister::register
     * @uses \Foundry\Masonry\Core\CoroutineRegister::isValid
     */
    public function testTick()
    {
        /** @var CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject $coroutine */
        $coroutine = $this->getMockForAbstractClass(CoroutineInterface::class);

        $coroutine
            ->expects($this->at(0))
            ->method('isValid')
            ->with()
            ->will($this->returnValue(true));

        $coroutine
            ->expects($this->at(1))
            ->method('tick')
            ->with();

        $coroutine
            ->expects($this->at(2))
            ->method('isValid')
            ->with()
            ->will($this->returnValue(true));

        $coroutine
            ->expects($this->at(3))
            ->method('tick')
            ->with();

        $coroutine
            ->expects($this->at(4))
            ->method('isValid')
            ->with()
            ->will($this->returnValue(false));

        $coroutineRegister = new CoroutineRegister();
        $coroutineRegister->register($coroutine);

        $this->assertTrue(
            $coroutineRegister->isValid()
        );

        $coroutineRegister->tick();

        $this->assertTrue(
            $coroutineRegister->isValid()
        );

        $coroutineRegister->tick();

        $this->assertFalse(
            $coroutineRegister->isValid()
        );

    }

}
