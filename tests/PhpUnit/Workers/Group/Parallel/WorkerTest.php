<?php
/**
 * WorkerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group\Parallel;

use Foundry\Masonry\Core\Pool\Status as PoolStatus;
use Foundry\Masonry\Core\Task\Status as TaskStatus;
use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Tests\PhpUnit\DeferredWrapper;
use Foundry\Masonry\Tests\PhpUnit\Workers\Group\AbstractGroupWorkerTest;
use Foundry\Masonry\Workers\Group\Parallel\Description;
use Foundry\Masonry\Workers\Group\Parallel\Worker;

/**
 * Class WorkerTest
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\Parallel\Worker
 */
class WorkerTest extends AbstractGroupWorkerTest
{
    /**
     * @return string
     */
    protected function getTestSubjectClassName()
    {
        return Worker::class;
    }

    /**
     * @test
     * @covers ::processDeferred
     * @uses \Foundry\Masonry\Core\CoroutineRegister
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Pool\Status
     * @uses \Foundry\Masonry\Core\Task\Status
     */
    public function testProcessDeferredSuccess()
    {
        $deferredWrapper = new DeferredWrapper();

        $getTask = function () {
            $task = $this->getMockTask();
            $task
                ->expects($this->once())
                ->method('getStatus')
                ->will($this->returnValue(new TaskStatus(TaskStatus::STATUS_COMPLETE)));
            return $task;
        };

        $childTask1 = $getTask();
        $childTask2 = $getTask();

        $getCoroutine = function () {
            $coroutine = $this->getMockCoroutine();
            $coroutine
                ->expects($this->any())
                ->method('tick')
                ->will($this->returnValue($coroutine));
            return $coroutine;
        };
        $coroutine1 = $getCoroutine();
        $coroutine1
            ->expects($this->exactly(3))
            ->method('isValid')
            ->will($this->onConsecutiveCalls(true, true, false));

        $coroutine2 = $getCoroutine();
        $coroutine2
            ->expects($this->exactly(2))
            ->method('isValid')
            ->will($this->onConsecutiveCalls(true, false));

        $poolDescription =
            $this
                ->getMockBuilder(Description::class)
                ->disableOriginalConstructor()
                ->getMock();
        $poolDescription
            ->expects($this->exactly(3))
            ->method('getStatus')
            ->with()
            ->will($this->onConsecutiveCalls(
                new PoolStatus(PoolStatus::STATUS_PENDING),
                new PoolStatus(PoolStatus::STATUS_PENDING),
                new PoolStatus(PoolStatus::STATUS_EMPTY)
            ));
        $poolDescription
            ->expects($this->exactly(2))
            ->method('getTask')
            ->with()
            ->will($this->onConsecutiveCalls(
                $childTask1,
                $childTask2
            ));

        $task = $this->getMockTask();
        $task
            ->expects($this->once())
            ->method('getDescription')
            ->with()
            ->will($this->returnValue($poolDescription));

        // We need to mock out some methods to test just this one function
        /** @var Worker|\PHPUnit_Framework_MockObject_MockObject $worker */
        $worker =
            $this
                ->getMockBuilder(Worker::class)
                ->setMethods(['processChildTask'])
                ->getMock();
        $worker
            ->expects($this->any())// Be more specific
            ->method('processChildTask')
            ->will($this->returnValueMap([
                [$childTask1, $coroutine1],
                [$childTask2, $coroutine2],
            ]));

        $processDeferred = $this->getObjectMethod($worker, 'processDeferred');

        /** @var \Generator $generator */
        $generator = $processDeferred($deferredWrapper->getDeferred(), $task);

        $this->assertInstanceOf(
            \Generator::class,
            $generator
        );

        // Begin processing
        $generator->next();
        // 3 calls for loop
        $generator->next();
        $generator->next();
        $generator->next();

        $this->assertEquals(
            'Processing parallel task group',
            $deferredWrapper->getNotificationOutput()
        );
        $this->assertNull(
            $deferredWrapper->getFailureOutput()
        );
        $this->assertEquals(
            'Parallel tasks completed successfully',
            $deferredWrapper->getSuccessOutput()
        );
    }

    /**
     * Note: This test additionally tests the parallel nature of the worker because $task2 should successfully complete
     * even after $task1 fails.
     * @test
     * @covers ::processDeferred
     * @uses \Foundry\Masonry\Core\CoroutineRegister
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Pool\Status
     * @uses \Foundry\Masonry\Core\Task\Status
     */
    public function testProcessDeferredFailure()
    {
        $deferredWrapper = new DeferredWrapper();

        $childTask1 = $this->getMockTask();
        $childTask1
            ->expects($this->once())
            ->method('getStatus')
            ->will($this->returnValue(
                new TaskStatus(TaskStatus::STATUS_FAILED)
            ));
        $childTask2 = $this->getMockTask();
        $childTask2
            ->expects($this->once())
            ->method('getStatus')
            ->will($this->returnValue(
                new TaskStatus(TaskStatus::STATUS_FAILED)
            ));

        $getCoroutine = function () {
            $coroutine = $this->getMockCoroutine();
            $coroutine
                ->expects($this->any())
                ->method('tick')
                ->will($this->returnValue($coroutine));
            return $coroutine;
        };

        /** @var CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject $coroutine1 */
        $coroutine1 = $getCoroutine();
        $coroutine1
            ->expects($this->exactly(4))
            ->method('isValid')
            ->will($this->onConsecutiveCalls(true, true, true, false));

        /** @var CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject $coroutine2 */
        $coroutine2 = $getCoroutine();
        $coroutine2
            ->expects($this->exactly(2))
            ->method('isValid')
            ->will($this->onConsecutiveCalls(true, false));

        $poolDescription =
            $this
                ->getMockBuilder(Description::class)
                ->disableOriginalConstructor()
                ->getMock();
        $poolDescription
            ->expects($this->exactly(3))
            ->method('getStatus')
            ->with()
            ->will($this->onConsecutiveCalls(
                new PoolStatus(PoolStatus::STATUS_PENDING),
                new PoolStatus(PoolStatus::STATUS_PENDING),
                new PoolStatus(PoolStatus::STATUS_EMPTY)
            ));
        $poolDescription
            ->expects($this->exactly(2))
            ->method('getTask')
            ->with()
            ->will($this->onConsecutiveCalls(
                $childTask1,
                $childTask2
            ));

        $task = $this->getMockTask();
        $task
            ->expects($this->once())
            ->method('getDescription')
            ->with()
            ->will($this->returnValue($poolDescription));

        // We need to mock out some methods to test just this one function
        /** @var Worker|\PHPUnit_Framework_MockObject_MockObject $worker */
        $worker =
            $this
                ->getMockBuilder(Worker::class)
                ->setMethods(['processChildTask'])
                ->getMock();
        $worker
            ->expects($this->any())// Be more specific
            ->method('processChildTask')
            ->will($this->returnValueMap([
                [$childTask1, $coroutine1],
                [$childTask2, $coroutine2],
            ]));

        $processDeferred = $this->getObjectMethod($worker, 'processDeferred');

        /** @var \Generator $generator */
        $generator = $processDeferred($deferredWrapper->getDeferred(), $task);

        $this->assertInstanceOf(
            \Generator::class,
            $generator
        );

        // Begin processing
        $generator->next();
        // 3 calls for loop
        $generator->next();
        $generator->next();
        $generator->next();

        $this->assertRegExp(
            '/Failed parallel tasks with exception: Failed tasks:/',
            $deferredWrapper->getNotificationOutput()
        );
        $this->assertEquals(
            'Failed parallel tasks',
            $deferredWrapper->getFailureOutput()
        );
        $this->assertNull(
            $deferredWrapper->getSuccessOutput()
        );
    }

    /**
     * @test
     * @covers ::processDeferred
     * @uses \Foundry\Masonry\Core\CoroutineRegister
     * @uses \Foundry\Masonry\Core\Notification
     */
    public function testProcessDeferredException()
    {
        $testMessage = 'test message';
        $deferredWrapper = new DeferredWrapper();

        $poolDescription =
            $this
                ->getMockBuilder(Description::class)
                ->disableOriginalConstructor()
                ->getMock();
        $poolDescription
            ->expects($this->at(0))
            ->method('getStatus')
            ->with()
            ->will($this->throwException(new \Exception($testMessage)));

        $task = $this->getMockTask();
        $task
            ->expects($this->once())
            ->method('getDescription')
            ->with()
            ->will($this->returnValue($poolDescription));

        // We need to mock out some methods to test just this one function
        /** @var Worker|\PHPUnit_Framework_MockObject_MockObject $worker */
        $worker =
            $this
                ->getMockBuilder(Worker::class)
                ->setMethods(['processChildTask'])
                ->getMock();
        $worker
            ->expects($this->any())// Be more specific
            ->method('processChildTask')
            ->will($this->returnValue($this->getMockCoroutine()));

        $processDeferred = $this->getObjectMethod($worker, 'processDeferred');

        /** @var \Generator $generator */
        $generator = $processDeferred($deferredWrapper->getDeferred(), $task);

        $this->assertInstanceOf(
            \Generator::class,
            $generator
        );

        // Move the generator on
        $generator->next();

        $this->assertEquals(
            "Failed parallel tasks with exception: {$testMessage}",
            $deferredWrapper->getNotificationOutput()
        );
        $this->assertEquals(
            'Failed parallel tasks',
            $deferredWrapper->getFailureOutput()
        );
        $this->assertNull(
            $deferredWrapper->getSuccessOutput()
        );
    }

    /**
     * @test
     * @covers ::getDescriptionTypes
     */
    public function testGetDescriptionTypes()
    {
        $worker = new Worker();

        $this->assertCount(
            1,
            $worker->getDescriptionTypes()
        );

        $this->assertContains(
            Description::class,
            $worker->getDescriptionTypes()
        );
    }
}
