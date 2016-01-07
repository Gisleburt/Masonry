<?php
/**
 * Module.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\WorkerModule;
use Foundry\Masonry\Interfaces\WorkerInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;


/**
 * Class Module
 * Testing the Module class
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass Foundry\Masonry\Core\WorkerModule
 */
class WorkerModuleTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     */
    public function testConstructEmpty()
    {
        $workers = [];

        $module = new WorkerModule($workers);
        $moduleWorkers = $this->getObjectAttribute($module, 'workers');

        $this->assertSame(
            $workers,
            $moduleWorkers
        );

    }

    /**
     * @test
     * @covers ::__construct
     * @covers Foundry\Masonry\Core\Mediator::addWorker
     */
    public function testConstructSingleWorker()
    {
        $worker = $this->getMockForAbstractClass('Foundry\Masonry\Interfaces\WorkerInterface');
        $workers = [
            $worker,
        ];

        $module = new WorkerModule($workers);
        $moduleWorkers = $this->getObjectAttribute($module, 'workers');

        $this->assertSame(
            $workers,
            $moduleWorkers
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @covers Foundry\Masonry\Core\Mediator::addWorker
     */
    public function testConstructMultiWorker()
    {
        $worker1 = $this->getMockForAbstractClass('Foundry\Masonry\Interfaces\WorkerInterface');
        $worker2 = $this->getMockForAbstractClass('Foundry\Masonry\Interfaces\WorkerInterface');
        $workers = [
            $worker1,
            $worker2,
        ];

        $module = new WorkerModule($workers);
        $moduleWorkers = $this->getObjectAttribute($module, 'workers');

        $this->assertSame(
            $workers,
            $moduleWorkers
        );

    }

    /**
     * @test
     * @covers ::getDescriptionTypes
     * @uses Foundry\Masonry\Core\WorkerModule::__construct
     */
    public function testGetDescriptionTypesEmpty()
    {
        $workers = [];

        $module = new WorkerModule($workers);

        $this->assertEmpty(
            $module->getDescriptionTypes()
        );
    }

    /**
     * @test
     * @covers ::getDescriptionTypes
     * @uses Foundry\Masonry\Core\WorkerModule::__construct
     */
    public function testGetDescriptionTypesPreSet()
    {
        $workers = [];

        $module = new WorkerModule($workers);

        $testMarker = new \stdClass(); // Use for reference checking
        $this->setObjectAttribute($module, 'descriptionTypes', $testMarker);

        $this->assertSame(
            $testMarker,
            $module->getDescriptionTypes()
        );
    }


    /**
     * @test
     * @covers ::getDescriptionTypes
     * @uses   Foundry\Masonry\Core\WorkerModule::__construct
     * @covers Foundry\Masonry\Core\Mediator::addWorker
     */
    public function testGetDescriptionTypesWorkers()
    {
        $description1 = 'Description One';
        $description2 = 'Description Two';
        $description3 = 'Description Three';

        $worker1 = $this->getMockForAbstractClass('Foundry\Masonry\Interfaces\WorkerInterface');
        $worker1
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([$description1, $description2]));

        $worker2 = $this->getMockForAbstractClass('Foundry\Masonry\Interfaces\WorkerInterface');
        $worker2
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([$description2, $description3]));

        $workers = [
            $worker1,
            $worker2,
        ];

        $module = new WorkerModule($workers);

        $this->assertSame(
            [
                $description1 => $description1,
                $description2 => $description2,
                $description3 => $description3,
            ],
            $module->getDescriptionTypes()
        );
    }

}
