<?php
/**
 * TaskInterfaceInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Task;
use Foundry\Masonry\Interfaces\Task\StatusInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class TaskTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Task
 */
class TaskTest extends TestCase
{
    /**
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|\Foundry\Masonry\Interfaces\Task\DescriptionInterface
     */
    protected function getDescription()
    {
        return $this->getMockBuilder('\Foundry\Masonry\Interfaces\Task\DescriptionInterface')
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @test
     * @covers ::__construct
     * @return void
     */
    public function testConstruct()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $this->assertSame(
            $description,
            $this->getObjectAttribute($task, 'description')
        );
    }

    /**
     * @test
     * @covers ::getDescription
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @return void
     */
    public function testGetDescription()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $this->assertSame(
            $description,
            $task->getDescription()
        );
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @uses \Foundry\Masonry\Core\Task::getHistory
     * @uses \Foundry\Masonry\Core\Task::start
     * @uses \Foundry\Masonry\Core\Task::cancel
     * @uses \Foundry\Masonry\Core\Task::complete
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\Status
     * @return void
     */
    public function testGetStatus()
    {
        $description = $this->getDescription();

        $task1 = new Task($description);
        $this->assertSame(
            StatusInterface::STATUS_NEW,
            (string)$task1->getStatus()
        );

        $task2 = new Task($description);
        $task2->start();
        $this->assertSame(
            StatusInterface::STATUS_IN_PROGRESS,
            (string)$task2->getStatus()
        );

        $task3 = new Task($description);
        $task3->start();
        $task3->cancel();
        $this->assertSame(
            StatusInterface::STATUS_DEFERRED,
            (string)$task3->getStatus()
        );

        $task4 = new Task($description);
        $task4->start();
        $task4->complete();
        $this->assertSame(
            StatusInterface::STATUS_COMPLETE,
            (string)$task4->getStatus()
        );
    }

    /**
     * @test
     * @covers ::getHistory
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @uses \Foundry\Masonry\Core\Task::getHistory
     * @uses \Foundry\Masonry\Core\Task::start
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @return void
     */
    public function testGetHistory()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $this->assertInstanceOf(
            '\Foundry\Masonry\Core\Task\History',
            $task->getHistory()
        );

        $this->assertCount(
            0,
            $task->getHistory()->getEvents()
        );

        $task->start();

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );
    }

    /**
     * @test
     * @covers ::start
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @uses \Foundry\Masonry\Core\Task::getHistory
     * @uses \Foundry\Masonry\Core\Task::getStatus
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\Status
     * @return void
     */
    public function testStart()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $this->assertSame(
            StatusInterface::STATUS_NEW,
            (string)$task->getStatus()
        );

        $this->assertSame(
            $task,
            $task->start()
        );

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );

        $this->assertSame(
            StatusInterface::STATUS_IN_PROGRESS,
            (string)$task->getStatus()
        );
    }

    /**
     * @test
     * @covers ::complete
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @uses \Foundry\Masonry\Core\Task::getHistory
     * @uses \Foundry\Masonry\Core\Task::getStatus
     * @uses \Foundry\Masonry\Core\Task::start
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @return void
     */
    public function testComplete()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $task->start();

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );

        $this->assertSame(
            $task,
            $task->complete()
        );

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );

        $this->assertSame(
            StatusInterface::STATUS_COMPLETE,
            (string)$task->getStatus()
        );
    }

    /**
     * @test
     * @covers ::cancel
     * @uses \Foundry\Masonry\Core\Task::__construct
     * @uses \Foundry\Masonry\Core\Task::getHistory
     * @uses \Foundry\Masonry\Core\Task::getStatus
     * @uses \Foundry\Masonry\Core\Task::start
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @return void
     */
    public function testCancel()
    {
        $description = $this->getDescription();
        $task = new Task($description);

        $task->start();

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );

        $this->assertSame(
            $task,
            $task->cancel()
        );

        $this->assertCount(
            1,
            $task->getHistory()->getEvents()
        );

        $this->assertSame(
            StatusInterface::STATUS_DEFERRED,
            (string)$task->getStatus()
        );
    }
}
