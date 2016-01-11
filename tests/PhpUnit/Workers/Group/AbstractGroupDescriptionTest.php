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

use Foundry\Masonry\Interfaces\Pool\StatusInterface;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Workers\Group\AbstractGroupDescription;

/**
 * Abstract Class Description
 *
 * @package Masonry
 * @see     https://github.com/Visionmongers/
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\AbstractGroupDescription
 */
abstract class AbstractGroupDescriptionTest extends TestCase
{
    /**
     * @var string
     */
    abstract protected function getClassName();

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstruct()
    {
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $class = $this->getClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class($pool);

        $this->assertSame(
            $pool,
            $this->getObjectAttribute($groupDescription, 'pool')
        );
    }

    /**
     * @test
     * @covers ::addTask
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     */
    public function testAddTask()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $pool
            ->expects($this->once())
            ->method('addTask')
            ->with($task)
            ->will($this->returnValue($pool));

        $class = $this->getClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class($pool);

        $this->assertSame(
            $groupDescription,
            $groupDescription->addTask($task)
        );
    }

    /**
     * @test
     * @covers ::getTask
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     */
    public function testGetTask()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $pool
            ->expects($this->once())
            ->method('getTask')
            ->with()
            ->will($this->returnValue($task));

        $class = $this->getClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class($pool);

        $this->assertSame(
            $task,
            $groupDescription->getTask()
        );
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription::__construct
     */
    public function testGetStatus()
    {
        /** @var StatusInterface|\PHPUnit_Framework_MockObject_MockObject $poolStatus */
        $poolStatus = $this->getMockForAbstractClass(StatusInterface::class);
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $pool
            ->expects($this->once())
            ->method('getStatus')
            ->with()
            ->will($this->returnValue($poolStatus));

        $class = $this->getClassName();
        /** @var AbstractGroupDescription $groupDescription */
        $groupDescription = new $class($pool);

        $this->assertSame(
            $poolStatus,
            $groupDescription->getStatus()
        );
    }
}
