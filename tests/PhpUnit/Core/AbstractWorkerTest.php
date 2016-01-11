<?php
/**
 * AbstractWorkerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\AbstractWorker;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class AbstractWorkerTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractWorker
 */
class AbstractWorkerTest extends TestCase
{

    /**
     * @test
     * @covers ::isTaskDescriptionValid
     */
    public function testIsTaskDescriptionValidSuccess()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task =
            $this
                ->getMockBuilder(TaskInterface::class)
                ->setMethods(['getDescription'])
                ->getMockForAbstractClass();
        $task
            ->expects($this->exactly(2))
            ->method('getDescription')
            ->with()
            ->will($this->returnValue(new \stdClass()));

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['getDescriptionTypes'])
                ->getMockForAbstractClass();

        $abstractWorker
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([
                'fakeClass',
                \stdClass::class,
                'anotherFakeClass',
            ]));

        $isTaskDescriptionValid = $this->getObjectMethod($abstractWorker, 'isTaskDescriptionValid');

        $this->assertTrue(
            $isTaskDescriptionValid($task)
        );
    }

    /**
     * @test
     * @covers ::isTaskDescriptionValid
     */
    public function testIsTaskDescriptionValidFailure()
    {
        /** @var TaskInterface|\PHPUnit_Framework_MockObject_MockObject $task */
        $task =
            $this
                ->getMockBuilder(TaskInterface::class)
                ->setMethods(['getDescription'])
                ->getMockForAbstractClass();
        $task
            ->expects($this->exactly(3))
            ->method('getDescription')
            ->with()
            ->will($this->returnValue(new \stdClass()));

        /** @var AbstractWorker|\PHPUnit_Framework_MockObject_MockObject $abstractWorker */
        $abstractWorker =
            $this
                ->getMockBuilder(AbstractWorker::class)
                ->setMethods(['getDescriptionTypes'])
                ->getMockForAbstractClass();

        $abstractWorker
            ->expects($this->once())
            ->method('getDescriptionTypes')
            ->with()
            ->will($this->returnValue([
                'fakeClass',
                'anotherFakeClass',
                'yetAnotherFake',
            ]));

        $isTaskDescriptionValid = $this->getObjectMethod($abstractWorker, 'isTaskDescriptionValid');

        $this->assertFalse(
            $isTaskDescriptionValid($task)
        );
    }
}
