<?php
/**
 * ArrayPoolTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\ArrayPool;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class ArrayPoolTest
 * @package Foundry\Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\ArrayPool
 */
class ArrayPoolTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task::__construct
     */
    public function testConstruct()
    {
        $task = $this->getMockForAbstractClass(TaskInterface::class);
        $description = $this->getMockForAbstractClass(DescriptionInterface::class);
        $namedTask = 'someTask';
        $parameters = [];

        $arrayPool =
            $this
                ->getMockBuilder(ArrayPool::class)
                ->disableOriginalConstructor()
                ->setMethods(['addTask', 'addPotentialTask'])
                ->getMock();

        $arrayPool
            ->expects($this->at(0))
            ->method('addTask')
            ->with($task);
        $arrayPool
            ->expects($this->at(1))
            ->method('addTask')
            ->with($this->isInstanceOf(TaskInterface::class));
        $arrayPool
            ->expects($this->at(2))
            ->method('addPotentialTask')
            ->with($namedTask, $parameters);

        $construct = $this->getObjectMethod($arrayPool, '__construct');
        $construct([
            0=>$task,
            1=>$description,
            $namedTask => $parameters
        ]);
    }
}
