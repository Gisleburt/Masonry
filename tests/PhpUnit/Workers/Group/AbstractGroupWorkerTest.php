<?php
/**
 * AbstractGroupWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group;

use Foundry\Masonry\Core\Coroutine;
use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Core\Task\Status;
use Foundry\Masonry\Interfaces\MediatorInterface;
use Foundry\Masonry\Interfaces\NotificationInterface;
use Foundry\Masonry\Interfaces\Task\History\ReasonInterface;
use Foundry\Masonry\Interfaces\Task\History\ResultInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\Core\AbstractWorkerTest;
use Foundry\Masonry\Tests\PhpUnit\Core\MediatorAwareTraitTest;
use Foundry\Masonry\Tests\PhpUnit\DeferredWrapper;
use Foundry\Masonry\Workers\Group\AbstractGroupWorker;
use Psr\Log\LoggerInterface;

/**
 * Abstract Class GroupWorker
 * Knows about mediators and coroutines
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractGroupWorkerTest extends AbstractWorkerTest
{
    use MediatorAwareTraitTest;

    /**
     * @return string
     */
    abstract protected function getTestSubjectClassName();

    /**
     * @return AbstractGroupWorker
     */
    protected function getTestSubject()
    {
        $class = $this->getTestSubjectClassName();
        return new $class();
    }

    /**
     * @test
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskThenString()
    {
        $testMessage = 'Test string';

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('complete')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf(ResultInterface::class),
                    $this->equalTo(ResultInterface::RESULT_SUCCEEDED)
                ),
                $this->logicalAnd(
                    $this->isInstanceOf(ReasonInterface::class),
                    $this->equalTo($testMessage)
                )
            )
            ->will($this->returnValue($task));

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $logger
            ->expects($this->once())
            ->method('info')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf(NotificationInterface::class),
                    $this->equalTo($testMessage),
                    $this->attributeEqualTo('priority', NotificationInterface::PRIORITY_NORMAL)
                )
            )
            ->will($this->returnValue(null));
        $deferred->resolve($testMessage);

    }

    /**
     * @test
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskOtherwiseString()
    {
        $testMessage = 'Test string';

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('complete')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf(ResultInterface::class),
                    $this->equalTo(ResultInterface::RESULT_FAILED)
                ),
                $this->logicalAnd(
                    $this->isInstanceOf(ReasonInterface::class),
                    $this->equalTo($testMessage)
                )
            )
            ->will($this->returnValue($task));

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $logger
            ->expects($this->once())
            ->method('error')
            ->with($this->logicalAnd(
                $this->isInstanceOf(NotificationInterface::class),
                $this->equalTo($testMessage),
                $this->attributeEqualTo('priority', NotificationInterface::PRIORITY_HIGH)
            ))
            ->will($this->returnValue(null));
        $deferred->reject($testMessage);
    }

    /**
     * @test
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskProgressString()
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
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task, $status);

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
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskThenNotification()
    {
        $testString = 'test string';
        $testNotification =
            $this
                ->getMockBuilder(Notification::class)
                ->disableOriginalConstructor()
                ->getMock();
        $testNotification
            ->expects($this->once())
            ->method('__toString')
            ->with()
            ->will($this->returnValue($testString));

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('complete')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf(ResultInterface::class),
                    $this->equalTo(ResultInterface::RESULT_SUCCEEDED)
                ),
                $this->logicalAnd(
                    $this->isInstanceOf(ReasonInterface::class)
                )
            )
            ->will($this->returnValue($task));

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $logger
            ->expects($this->once())
            ->method('info')
            ->with($testNotification)
            ->will($this->returnValue(null));

        $deferred->resolve($testNotification);

    }

    /**
     * @test
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskOtherwiseNotification()
    {
        $testString = 'test string';
        $testNotification =
            $this
                ->getMockBuilder(Notification::class)
                ->disableOriginalConstructor()
                ->getMock();
        $testNotification
            ->expects($this->once())
            ->method('__toString')
            ->with()
            ->will($this->returnValue($testString));

        $deferredWrapper = new DeferredWrapper();

        /** @var LoggerInterface|\PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockForAbstractClass(LoggerInterface::class);

        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $task
            ->expects($this->once())
            ->method('complete')
            ->with(
                $this->logicalAnd(
                    $this->isInstanceOf(ResultInterface::class),
                    $this->equalTo(ResultInterface::RESULT_FAILED)
                ),
                $this->logicalAnd(
                    $this->isInstanceOf(ReasonInterface::class)
                )
            )
            ->will($this->returnValue($task));

        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $mediator
            ->expects($this->once())
            ->method('process')
            ->with($task)
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $logger
            ->expects($this->once())
            ->method('error')
            ->with($testNotification)
            ->will($this->returnValue(null));
        $deferred->reject($testNotification);
    }

    /**
     * @test
     * @covers ::processChildTask
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\Mediator\MediatorAwareTrait
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Injection\HasLogger
     */
    public function testProcessChildTaskProgressNotification()
    {
        $testNotification =
            $this
                ->getMockBuilder(Notification::class)
                ->disableOriginalConstructor()
                ->getMock();

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
            ->will($this->returnValue(new Coroutine(
                $deferredWrapper->getDeferred(),
                $deferredWrapper->getGenerator()
            )));

        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupWorker $groupWorker */
        $groupWorker = new $class();
        $groupWorker
            ->setLogger($logger);

        $processChildTask = $this->getObjectMethod($groupWorker, 'processChildTask');

        $processChildTask($task);

        // Tests
        $deferred = $deferredWrapper->getDeferred();

        $logger
            ->expects($this->once())
            ->method('notice')
            ->with($testNotification)
            ->will($this->returnValue(null));
        $deferred->notify($testNotification);

    }
}
