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
use Foundry\Masonry\Interfaces\WorkerInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractWorkerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractWorker
 */
abstract class AbstractWorkerTest extends TestCase
{

    /**
     * @return AbstractWorker
     */
    abstract protected function getTestSubject();

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

    /**
     * @test
     * @covers ::getLogger
     */
    public function testGetLogger()
    {

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this
            ->getMockBuilder(LoggerInterface::class)
            ->setMethods([])
            ->getMock();


        $abstractWorker = $this->getTestSubject();

        $getLogger = $this->getObjectMethod($abstractWorker, 'getLogger');

        $this->assertNull(
            $getLogger()
        );

        $abstractWorker->setLogger($logger);

        $this->assertSame(
            $logger,
            $getLogger()
        );
    }
}
