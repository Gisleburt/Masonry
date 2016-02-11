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
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\WorkerModuleDefinitionInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Workers\Group\Serial;

/**
 * Class ArrayPoolTest
 * @package Foundry\Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\ArrayPool
 */
class ArrayPoolTest extends TestCase
{

    /**
     * @var ModuleRegisterInterface
     */
    private $oldModuleRegister;

    /**
     * Some tests change states so record them before the test here.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oldModuleRegister = $this->getStaticAttribute(GlobalRegister::class, 'moduleRegister');
    }

    /**
     * Put the system back into it's old state.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->setStaticAttribute(GlobalRegister::class, 'moduleRegister', $this->oldModuleRegister);
    }

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
            0 => $task,
            1 => $description,
            $namedTask => $parameters
        ]);
    }

    /**
     * @test
     * @covers ::addPotentialTask
     * @uses \Foundry\Masonry\Core\AbstractDescription
     * @uses \Foundry\Masonry\Core\ArrayPool
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription
     */
    public function testAddPotentialTask()
    {
        $notAClassAlias = 'NotAClass';
        $serialClassAlias = 'Serial';
        $serialClass = Serial\Description::class;

        $arrayPool =
            $this
                ->getMockBuilder(ArrayPool::class)
                ->disableOriginalConstructor()
                ->setMethods(['addTask', 'getTaskClassName'])
                ->getMock();
        $arrayPool
            ->expects($this->at(0))
            ->method('getTaskClassName')
            ->with($notAClassAlias)
            ->will($this->returnValue(null));
        $arrayPool
            ->expects($this->at(1))
            ->method('getTaskClassName')
            ->with($serialClassAlias)
            ->will($this->returnValue($serialClass));
        $arrayPool
            ->expects($this->once())
            ->method('addTask')
            ->with($this->isInstanceOf(TaskInterface::class));

        $addPotentialTask = $this->getObjectMethod($arrayPool, 'addPotentialTask');
        $this->assertSame(
            $arrayPool,
            $addPotentialTask($notAClassAlias, [$serialClassAlias => ['tasks' => []]])
        );
    }

    /**
     * @test
     * @covers ::addPotentialTask
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage 'NotAClass' did not match a class
     */
    public function testAddPotentialTaskNoClass()
    {
        $notAClassAlias = 'NotAClass';

        $arrayPool =
            $this
                ->getMockBuilder(ArrayPool::class)
                ->disableOriginalConstructor()
                ->setMethods(['addTask', 'getTaskClassName'])
                ->getMock();
        $arrayPool
            ->expects($this->at(0))
            ->method('getTaskClassName')
            ->with($notAClassAlias)
            ->will($this->returnValue(null));
        $arrayPool
            ->expects($this->never())
            ->method('addTask');

        $addPotentialTask = $this->getObjectMethod($arrayPool, 'addPotentialTask');
        $this->assertSame(
            $arrayPool,
            $addPotentialTask($notAClassAlias, null)
        );
    }

    /**
     * @test
     * @covers ::addPotentialTask
     * @expectedException \RuntimeException
     * @expectedExceptionMessage 'stdClass' was not a description
     */
    public function testAddPotentialTaskNoDescription()
    {
        $notAClassAlias = 'NotADescription';

        $arrayPool =
            $this
                ->getMockBuilder(ArrayPool::class)
                ->disableOriginalConstructor()
                ->setMethods(['addTask', 'getTaskClassName'])
                ->getMock();
        $arrayPool
            ->expects($this->at(0))
            ->method('getTaskClassName')
            ->with($notAClassAlias)
            ->will($this->returnValue(\stdClass::class));
        $arrayPool
            ->expects($this->never())
            ->method('addTask');

        $addPotentialTask = $this->getObjectMethod($arrayPool, 'addPotentialTask');
        $this->assertSame(
            $arrayPool,
            $addPotentialTask($notAClassAlias, null)
        );
    }

    /**
     * @test
     * @covers ::getTaskClassName
     * @uses \Foundry\Masonry\Core\ArrayPool::__construct
     * @uses \Foundry\Masonry\Core\GlobalRegister
     */
    public function testGetTaskClassName()
    {
        $moduleName = 'Module';
        $descriptionAlias = 'Description';
        $taskName = "$moduleName:$descriptionAlias";
        $taskClassName = 'TaskClassName';

        $workerModule = $this->getMockForAbstractClass(WorkerModuleDefinitionInterface::class);
        $workerModule
            ->expects($this->once())
            ->method('lookupDescription')
            ->with($descriptionAlias)
            ->will($this->returnValue($taskClassName));

        /** @var ModuleRegisterInterface|\PHPUnit_Framework_MockObject_MockObject $moduleRegister */
        $moduleRegister = $this->getMockForAbstractClass(ModuleRegisterInterface::class);
        $moduleRegister
            ->expects($this->once())
            ->method('getWorkerModule')
            ->with($moduleName)
            ->will($this->returnValue($workerModule));
        GlobalRegister::setModuleRegister($moduleRegister);

        $arrayPool = new ArrayPool([]);

        $getTaskClassName = $this->getObjectMethod($arrayPool, 'getTaskClassName');

        $this->assertSame(
            $taskClassName,
            $getTaskClassName($taskName)
        );
    }

    /**
     * @test
     * @covers ::getTaskClassName
     * @uses \Foundry\Masonry\Core\ArrayPool::__construct
     * @uses \Foundry\Masonry\Core\GlobalRegister
     */
    public function testGetTaskClassNameNotFound()
    {
        $moduleName = 'Module';
        $descriptionAlias = 'Description';
        $taskName = "$moduleName:$descriptionAlias";

        /** @var ModuleRegisterInterface|\PHPUnit_Framework_MockObject_MockObject $moduleRegister */
        $moduleRegister = $this->getMockForAbstractClass(ModuleRegisterInterface::class);
        $moduleRegister
            ->expects($this->once())
            ->method('getWorkerModule')
            ->with($moduleName)
            ->will($this->throwException(new \Exception()));
        GlobalRegister::setModuleRegister($moduleRegister);

        $arrayPool = new ArrayPool([]);

        $getTaskClassName = $this->getObjectMethod($arrayPool, 'getTaskClassName');

        $this->assertNull(
            $getTaskClassName($taskName)
        );
    }
}
