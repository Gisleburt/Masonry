<?php
/**
 * AbstractGroupDescriptionTest.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group;

use Foundry\Masonry\Core\ArrayPool;
use Foundry\Masonry\Interfaces\Pool\StatusInterface;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\Core\AbstractDescriptionTest;
use Foundry\Masonry\Workers\Group\AbstractGroupDescription;

/**
 * Abstract Class Description
 *
 * @package Masonry
 * @see     https://github.com/Visionmongers/
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\AbstractGroupDescription
 */
abstract class AbstractGroupDescriptionTest extends AbstractDescriptionTest
{
    /**
     * @var string
     */
    abstract protected function getTestSubjectClassName();

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\ArrayPool
     */
    public function testConstruct()
    {
        // Mock Data
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $tasks = [
            $task,
        ];

        // Create the class
        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class($tasks);

        // Test the pool was created correctly
        /** @var ArrayPool $pool */
        $pool = $this->getObjectAttribute($groupDescription, 'pool');
        $this->assertInstanceOf(
            ArrayPool::class,
            $pool
        );
        $this->assertSame(
            $task,
            $groupDescription->getTask()
        );

    }

    /**
     * @test
     * @covers ::addTask
     * @covers ::getTask
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     * @uses \Foundry\Masonry\Core\ArrayPool
     */
    public function testAddTask()
    {
        // Mock Data
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        // Create the class
        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class([]);

        // Test
        $this->assertSame(
            $groupDescription,
            $groupDescription->addTask($task)
        );
        $this->assertSame(
            $task,
            $groupDescription->getTask()
        );
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::addTask
     * @uses \Foundry\Masonry\Core\ArrayPool
     */
    public function testGetStatus()
    {
        // Mock Data
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);

        // Create the class
        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class([]);

        // Tests (note: not an exact match)
        $this->assertEquals(
            StatusInterface::STATUS_EMPTY,
            $groupDescription->getStatus()
        );

        $groupDescription->addTask($task);

        $this->assertEquals(
            StatusInterface::STATUS_PENDING,
            $groupDescription->getStatus()
        );
    }

    /**
     * @test
     * @covers ::createFromParameters
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::flattenKeys
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::flatten
     */
    public function testCreateFromParameters()
    {
        // Mock Data
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $tasks = [
            'tasks' => [ $task ],
        ];

        // Create the class
        $class = $this->getTestSubjectClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = $class::createFromParameters($tasks);

        // Test the pool was created correctly
        /** @var ArrayPool $pool */
        $pool = $this->getObjectAttribute($groupDescription, 'pool');
        $this->assertInstanceOf(
            ArrayPool::class,
            $pool
        );
        $this->assertSame(
            $task,
            $groupDescription->getTask()
        );

    }

}
