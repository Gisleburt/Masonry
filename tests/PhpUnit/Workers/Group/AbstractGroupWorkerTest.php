<?php
/**
 * AbstractGroupWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group;

use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Core\Task\Status;
use Foundry\Masonry\Interfaces\MediatorInterface;
use Foundry\Masonry\Interfaces\NotificationInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\DeferredWrapper;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Workers\Group\AbstractGroupWorker;
use Psr\Log\LoggerInterface;

/**
 * Abstract Class GroupWorker
 * Knows about mediators and coroutines
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractGroupWorkerTest extends TestCase
{

    abstract protected function getClassName();

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskThenString()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = 'Test string';
        $logger
            ->expects($this->once())
            ->method('info')
            ->with($this->logicalAnd(
                $this->isInstanceOf(NotificationInterface::class),
                $this->equalTo($test),
                $this->attributeEqualTo('priority', NotificationInterface::PRIORITY_NORMAL)
            ))
            ->will($this->returnValue(null));
        $deferred->resolve($test);

//        $this->assertInstanceOf(
//            Status::class,
//            $status
//        );
//
//        $this->assertSame(
//            Status::STATUS_COMPLETE,
//            (string)$status
//        );

    }

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskOtherwiseString()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = 'Test string';
        $logger
            ->expects($this->once())
            ->method('error')
            ->with($this->logicalAnd(
                $this->isInstanceOf(NotificationInterface::class),
                $this->equalTo($test),
                $this->attributeEqualTo('priority', NotificationInterface::PRIORITY_HIGH)
            ))
            ->will($this->returnValue(null));
        $deferred->reject($test);

//        $this->assertInstanceOf(
//            Status::class,
//            $status
//        );
//
//        $this->assertSame(
//            Status::STATUS_COMPLETE,
//            (string)$status
//        );

    }

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskProgressString()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = 'Test string';
        $logger
            ->expects($this->once())
            ->method('notice')
            ->with($this->logicalAnd(
                $this->isInstanceOf(NotificationInterface::class),
                $this->equalTo($test),
                $this->attributeEqualTo('priority', NotificationInterface::PRIORITY_INFO)
            ))
            ->will($this->returnValue(null));
        $deferred->notify($test);

        $this->assertNull(
            $status
        );

    }

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskThenNotification()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = $this->getMockForAbstractClass(NotificationInterface::class);
        $logger
            ->expects($this->once())
            ->method('info')
            ->with($test)
            ->will($this->returnValue(null));
        $deferred->resolve($test);

//        $this->assertInstanceOf(
//            Status::class,
//            $status
//        );
//
//        $this->assertSame(
//            Status::STATUS_COMPLETE,
//            (string)$status
//        );

    }

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskOtherwiseNotification()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = $this->getMockForAbstractClass(NotificationInterface::class);
        $logger
            ->expects($this->once())
            ->method('error')
            ->with($test)
            ->will($this->returnValue(null));
        $deferred->reject($test);

//        $this->assertInstanceOf(
//            Status::class,
//            $status
//        );
//
//        $this->assertSame(
//            Status::STATUS_COMPLETE,
//            (string)$status
//        );

    }

    /**
     * @test
     * @covers ::processTask
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\AbstractWorker::getLogger
     */
    public function testProcessTaskProgressNotification()
    {
        /** @var Status|null $status */
        $status = null;

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue($deferredWrapper->getDeferred()->promise()));

        $class = $this->getClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setMediator($mediator)
            ->setLogger($logger);

        $processTask = $this->getObjectMethod($groupWorker, 'processTask');

        $processTask($task, $status);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $test = $this->getMockForAbstractClass(NotificationInterface::class);
        $logger
            ->expects($this->once())
            ->method('notice')
            ->with($test)
            ->will($this->returnValue(null));
        $deferred->notify($test);

        $this->assertNull(
            $status
        );

    }
}
