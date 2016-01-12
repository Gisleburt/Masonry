<?php
/**
 * WorkerTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group\Serial;

use Foundry\Masonry\Tests\PhpUnit\Workers\Group\AbstractGroupWorkerTest;
use Foundry\Masonry\Workers\Group\Serial\Description;
use Foundry\Masonry\Workers\Group\Serial\Worker;

/**
 * Class WorkerTest
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\Serial\Worker
 */
class WorkerTest extends AbstractGroupWorkerTest
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return Worker::class;
    }

    /**
     * @test
     * @covers ::getDescriptionTypes
     */
    public function testGetDescriptionTypes()
    {
        $worker = new Worker();

        $this->assertCount(
            1,
            $worker->getDescriptionTypes()
        );

        $this->assertContains(
            Description::class,
            $worker->getDescriptionTypes()
        );
    }
}
