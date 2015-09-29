<?php
/**
 * PoolTes.php
 * PHP version 5.4
 * 2015-09-29
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Pool;
use Foundry\Masonry\Core\Task;
use Foundry\Masonry\Interfaces\Pool\StatusInterface;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class PoolTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Pool
 */
class PoolTest extends TestCase
{

    /**
     * @return \Foundry\Masonry\Core\Task
     */
    protected function getTask()
    {
        /** @var DescriptionInterface|\PHPUnit_Framework_MockObject_MockObject $description */
        $description = $this->getMockBuilder('\Foundry\Masonry\Interfaces\Task\DescriptionInterface')
                            ->disableOriginalConstructor()
                            ->getMock();
        return new Task($description);
    }

    /**
     * @test
     * @covers ::addTask
     * @uses \Foundry\Masonry\Core\Pool::getTask
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\Status
     * @return void
     */
    public function testAddTask()
    {
        $task = $this->getTask();
        $pool = new Pool();
        $pool->addTask($task);
        $this->assertSame(
            $task,
            $pool->getTask()
        );
    }

    /**
     * @test
     * @covers ::getTask
     * @uses \Foundry\Masonry\Core\Pool::addTask
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\Status
     * @return void
     */
    public function testGetTask()
    {
        $pool = new Pool();

        $task1 = $this->getTask();
        $task2 = $this->getTask();
        $pool->addTask($task1);
        $pool->addTask($task2);

        $this->assertSame(
            $task1,
            $pool->getTask()
        );
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Core\Pool::addTask
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Pool\Status
     * @return void
     */
    public function testGetStatus()
    {
        $task = $this->getTask();
        $pool = new Pool();

        $this->assertSame(
            StatusInterface::STATUS_EMPTY,
            (string)$pool->getStatus()
        );

        $pool->addTask($task);

        $this->assertSame(
            StatusInterface::STATUS_PENDING,
            (string)$pool->getStatus()
        );
    }

    /**
     * @test
     * @covers ::addTask
     * @uses \Foundry\Masonry\Core\Pool::getTask
     * @uses \Foundry\Masonry\Core\Pool::getStatus
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Core\Task\Status
     * @uses \Foundry\Masonry\Core\Task\History
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Pool\Status
     * @return void
     */
    public function testAddCompletedTask()
    {
        $task = $this->getTask();
        $task->start()->complete();

        $pool = new Pool();
        $pool->addTask($task);
        $this->assertNull(
            $pool->getTask()
        );
    }
}
