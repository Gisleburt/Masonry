<?php
/**
 * StatusInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Task;

use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\Task\Status;
use Foundry\Masonry\Core\Exception\InvalidTaskStatus;

/**
 * Class StatusTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Task\Status
 */
class StatusTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task\Status::getStatus
     * @return void
     */
    public function testConstruct()
    {
        $status = new Status();
        $this->assertEquals(
            Status::STATUS_NEW,
            $status->getStatus()
        );

        $status = new Status(Status::STATUS_IN_PROGRESS);
        $this->assertEquals(
            Status::STATUS_IN_PROGRESS,
            $status->getStatus()
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \Foundry\Masonry\Core\Exception\InvalidTaskStatus
     * @return void
     */
    public function testConstructException()
    {
        new Status('Not a real status');
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Core\Task\Status::__construct
     * @return void
     */
    public function testGetStatus()
    {

        $status = new Status();
        $this->assertEquals(
            Status::STATUS_NEW,
            $status->getStatus()
        );

        $status = new Status(Status::STATUS_IN_PROGRESS);
        $this->assertEquals(
            Status::STATUS_IN_PROGRESS,
            $status->getStatus()
        );
    }

    /**
     * @test
     * @covers ::__toString
     * @uses \Foundry\Masonry\Core\Task\Status::__construct
     * @uses \Foundry\Masonry\Core\Task\Status::getStatus
     * @return void
     */
    public function testToString()
    {

        $status = new Status();
        $this->assertEquals(
            Status::STATUS_NEW,
            $status->getStatus()
        );

        $status = new Status(Status::STATUS_IN_PROGRESS);
        $this->assertEquals(
            Status::STATUS_IN_PROGRESS,
            (string)$status
        );
    }
}
