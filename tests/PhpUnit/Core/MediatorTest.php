<?php
/**
 * MediatorTest.php
 * PHP version 5.4
 * 2015-09-29
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Mediator;
use Foundry\Masonry\Core\Task;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Interfaces\WorkerInterface;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use React\Promise\Promise;

/**
 * Class MediatorTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Mediator
 */
class MediatorTest extends TestCase
{

    /**
     * @return WorkerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockWorker()
    {
        return $this->getMockBuilder('\Foundry\Masonry\Interfaces\WorkerInterface')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return DescriptionInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockDescription()
    {
        return $this->getMockBuilder('\Foundry\Masonry\Interfaces\Task\DescriptionInterface')
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @test
     * @covers ::addWorker
     * @return void
     */
    public function testAddWorker()
    {
        $worker = $this->getMockWorker();
        $mediator = new Mediator();

        $this->assertSame(
            $mediator,
            $mediator->addWorker($worker)
        );

        $this->assertSame(
            [$worker],
            $this->getObjectAttribute($mediator, 'workers')
        );
    }

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\Mediator::addWorker
     * @uses \Foundry\Masonry\Core\Task
     * @return void
     */
    public function testProcess()
    {
        $promise = new Promise(function () {
            return true;

        });

        $description = $this->getMockDescription();

        $task = new Task($description);

        $worker = $this->getMockWorker();
        $worker->expects($this->once())
               ->method('process')
               ->with($task)
               ->will($this->returnValue($promise));
        $worker->expects($this->once())
               ->method('getDescriptionTypes')
               ->will($this->returnValue([get_class($description)]));

        $mediator = new Mediator();
        $mediator->addWorker($worker);

        $this->assertSame(
            $promise,
            $mediator->process($task)
        );

    }

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\Task
     * @expectedException \Foundry\Masonry\Core\Exception\NoWorkerFound
     * @return void
     */
    public function testProcessNoWorkers()
    {
        $description = $this->getMockDescription();
        $task = new Task($description);

        $mediator = new Mediator();
        $mediator->process($task);
    }

    /**
     * @test
     * @covers ::process
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Core\Mediator::addWorker
     * @expectedException \Foundry\Masonry\Core\Exception\NoWorkerFound
     * @return void
     */
    public function testProcessNoValidWorker()
    {
        $description = $this->getMockDescription();
        $task = new Task($description);

        $worker = $this->getMockWorker();
        $worker->expects($this->once())
            ->method('getDescriptionTypes')
            ->will($this->returnValue(['SomeOtherTaskDescription']));

        $mediator = new Mediator();
        $mediator->addWorker($worker);
        $mediator->process($task);
    }
}
