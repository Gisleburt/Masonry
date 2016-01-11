<?php
/**
 * AbstractCoroutineWorkerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\AbstractCoroutineWorker;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\Coroutine;


/**
 * Class AbstractCoroutineWorkerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractCoroutineWorker
 */
class AbstractCoroutineWorkerTest extends TestCase
{

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\AbstractCoroutineWorker::isTaskDescriptionValid
     * @uses \React\Promise\Deferred
     * @uses \Foundry\Masonry\Core\Coroutine
     */
    public function testProcessSuccess()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var AbstractCoroutineWorker|\PHPUnit_Framework_MockObject_MockObject $abstractCoroutineWorker */
        $abstractCoroutineWorker =
            $this
                ->getMockBuilder(AbstractCoroutineWorker::class)
                ->setMethods(['isTaskDescriptionValid','processDeferred'])
                ->getMockForAbstractClass();
        $abstractCoroutineWorker
            ->expects($this->once())
            ->method('isTaskDescriptionValid')
            ->with($task)
            ->will($this->returnValue(true));
        $abstractCoroutineWorker
            ->expects($this->once())
            ->method('processDeferred')
            ->will($this->returnCallback(function() {
                yield;
            }));

        $coroutine = $abstractCoroutineWorker->process($task);

        $this->assertInstanceOf(
            Coroutine::class,
            $coroutine
        );

        $this->assertTrue(
            $coroutine->isValid()
        );
    }

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\AbstractCoroutineWorker::isTaskDescriptionValid
     * @uses \React\Promise\Deferred
     * @uses \Foundry\Masonry\Core\Coroutine
     */
    public function testProcessFailure()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var AbstractCoroutineWorker|\PHPUnit_Framework_MockObject_MockObject $abstractCoroutineWorker */
        $abstractCoroutineWorker =
            $this
                ->getMockBuilder(AbstractCoroutineWorker::class)
                ->setMethods(['isTaskDescriptionValid'])
                ->getMockForAbstractClass();
        $abstractCoroutineWorker
            ->expects($this->once())
            ->method('isTaskDescriptionValid')
            ->with($task)
            ->will($this->returnValue(false));

        $coroutine = $abstractCoroutineWorker->process($task);

        $this->assertInstanceOf(
            Coroutine::class,
            $coroutine
        );

        $this->assertFalse(
            $coroutine->isValid()
        );
    }

}
