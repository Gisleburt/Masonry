<?php
/**
 * CoroutineTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\Coroutine;
use React\Promise\Deferred;
use React\Promise\Promise;


/**
 * Class CoroutineTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Coroutine
 */
class CoroutineTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $generatorGenerator = function() { yield ; };
        /** @var \Generator $generator */
        $generator = $generatorGenerator();
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, $generator);

        $this->assertSame(
            $deferred,
            $this->getObjectAttribute($coroutine, 'deferred')
        );

        $this->assertSame(
            $generator,
            $this->getObjectAttribute($coroutine, 'generator')
        );
    }

    /**
     * @test
     * @covers ::tick
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     * @uses \Foundry\Masonry\Core\Coroutine::isValid
     */
    public function testTick()
    {
        $testValue = 'testValue';
        $generatorGenerator = function() use ($testValue) { yield $testValue; };
        /** @var \Generator $generator */
        $generator = $generatorGenerator();
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, $generator);

        $this->assertSame(
            $testValue,
            $coroutine->tick()
        );
    }

    /**
     * @test
     * @covers ::tick
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     * @uses \Foundry\Masonry\Core\Coroutine::isValid
     * @expectedException \Foundry\Masonry\Core\Exception\InvalidCoroutine
     */
    public function testTickException()
    {
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, null);

        $coroutine->tick();
    }

    /**
     * @test
     * @covers ::getPromise
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     * @uses \Foundry\Masonry\Core\Coroutine::isValid
     */
    public function testGetPromise()
    {
        /** @var Promise|\PHPUnit_Framework_MockObject_MockObject $promise */
        $promise =
            $this
                ->getMockBuilder(Promise::class)
                ->disableOriginalConstructor()
                ->getMock();

        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);
        $deferred
            ->expects($this->once())
            ->method('promise')
            ->with()
            ->will($this->returnValue($promise));

        $coroutine = new Coroutine($deferred, null);

        $this->assertSame(
            $promise,
            $coroutine->getPromise()
        );
    }

    /**
     * @test
     * @covers ::isValid
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     */
    public function testIsValidTrue()
    {
        $generatorGenerator = function() { yield ; };
        /** @var \Generator $generator */
        $generator = $generatorGenerator();
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, $generator);

        $this->assertTrue(
            $coroutine->isValid()
        );
    }

    /**
     * @test
     * @covers ::isValid
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     */
    public function testIsValidFinished()
    {
        $generatorGenerator = function() { yield ; };
        /** @var \Generator $generator */
        $generator = $generatorGenerator();
        $generator->next();
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, $generator);

        $this->assertFalse(
            $coroutine->isValid()
        );
    }

    /**
     * @test
     * @covers ::isValid
     * @uses \Foundry\Masonry\Core\Coroutine::__construct
     */
    public function testIsValidNoGenerator()
    {
        /** @var Deferred|\PHPUnit_Framework_MockObject_MockObject $deferred */
        $deferred = $this->getMock(Deferred::class);

        $coroutine = new Coroutine($deferred, null);

        $this->assertFalse(
            $coroutine->isValid()
        );
    }

}
