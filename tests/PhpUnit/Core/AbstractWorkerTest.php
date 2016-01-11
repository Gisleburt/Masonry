<?php
/**
 * AbstractWorkerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\AbstractWorker;
use Foundry\Masonry\Core\Coroutine;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class AbstractWorkerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractWorker
 */
class AbstractWorkerTest extends TestCase
{

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\AbstractWorker::isTaskDescriptionValid
     * @uses \React\Promise\Deferred
     * @uses \Foundry\Masonry\Core\Coroutine
     */
    public function testProcessSuccess()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['isTaskDescriptionValid', 'processDeferred'])
                ->getMockForAbstractClass();
        $abstractWorker
            ->expects($this->once())
            ->method('isTaskDescriptionValid')
            ->with($task)
            ->will($this->returnValue(true));
        $abstractWorker
            ->expects($this->once())
            ->method('processDeferred')
            ->will($this->returnCallback(function () {
                yield;
            }));

        $coroutine = $abstractWorker->process($task);

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
     * @uses \Foundry\Masonry\Core\AbstractWorker::isTaskDescriptionValid
     * @uses \React\Promise\Deferred
     * @uses \Foundry\Masonry\Core\Coroutine
     */
    public function testProcessFailure()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['isTaskDescriptionValid'])
                ->getMockForAbstractClass();
        $abstractWorker
            ->expects($this->once())
            ->method('isTaskDescriptionValid')
            ->with($task)
            ->will($this->returnValue(false));

        $coroutine = $abstractWorker->process($task);

        $this->assertInstanceOf(
            Coroutine::class,
            $coroutine
        );

        $this->assertFalse(
            $coroutine->isValid()
        );
    }


    /**
     * @test
     * @covers ::isTaskDescriptionValid
     */
    public function testIsTaskDescriptionValidSuccess()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task =
            $this
                ->getMockBuilder(TaskInterface::class)
                ->setMethods(['getDescription'])
                ->getMockForAbstractClass();
        $task
            ->expects($this->exactly(2))
            ->method('getDescription')
            ->with()
            ->will($this->returnValue(new \stdClass()));

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['getDescriptionTypes'])
                ->getMockForAbstractClass();

        $abstractWorker
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([
                'fakeClass',
                \stdClass::class,
                'anotherFakeClass',
            ]));

        $isTaskDescriptionValid = $this->getObjectMethod($abstractWorker, 'isTaskDescriptionValid');

        $this->assertTrue(
            $isTaskDescriptionValid($task)
        );
    }

    /**
     * @test
     * @covers ::isTaskDescriptionValid
     */
    public function testIsTaskDescriptionValidFailure()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task =
            $this
                ->getMockBuilder(TaskInterface::class)
                ->setMethods(['getDescription'])
                ->getMockForAbstractClass();
        $task
            ->expects($this->exactly(3))
            ->method('getDescription')
            ->with()
            ->will($this->returnValue(new \stdClass()));

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['getDescriptionTypes'])
                ->getMockForAbstractClass();

        $abstractWorker
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([
                'fakeClass',
                'anotherFakeClass',
                'yetAnotherFake',
            ]));

        $isTaskDescriptionValid = $this->getObjectMethod($abstractWorker, 'isTaskDescriptionValid');

        $this->assertFalse(
            $isTaskDescriptionValid($task)
        );
    }
}
