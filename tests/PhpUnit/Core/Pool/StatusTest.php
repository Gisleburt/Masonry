<?php
/**
 * Status.php
 * PHP version 5.4
 * 2015-09-24
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core\Pool;

use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\Pool\Status;

/**
 * Class Status
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Pool\Status
 */
class StatusTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Pool\Status::getStatus
     * @return void
     */
    public function testConstruct()
    {
        $status = new Status(Status::STATUS_PENDING);

        $this->assertNotEmpty(
            $status->getStatus()
        );

        $this->assertSame(
            Status::STATUS_PENDING,
            $status->getStatus()
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \Foundry\Masonry\Core\Exception\InvalidPoolStatus
     * @return void
     */
    public function testConstructException()
    {
        $status = new Status('not a valid status');
    }

    /**
     * @test
     * @covers ::getStatus
     * @uses \Foundry\Masonry\Core\Pool\Status::__construct
     * @return void
     */
    public function testGetStatus()
    {
        $status = new Status(Status::STATUS_PENDING);

        $this->assertNotEmpty(
            $status->getStatus()
        );

        $this->assertSame(
            Status::STATUS_PENDING,
            $status->getStatus()
        );
    }

    /**
     * @test
     * @covers ::__toString
     * @uses \Foundry\Masonry\Core\Pool\Status::__construct
     * @uses \Foundry\Masonry\Core\Pool\Status::getStatus
     * @return void
     */
    public function testToString()
    {
        $status = new Status(Status::STATUS_PENDING);

        $this->assertNotEmpty(
            $status->getStatus()
        );

        $this->assertSame(
            Status::STATUS_PENDING,
            $status->__toString()
        );

        $this->assertSame(
            Status::STATUS_PENDING,
            (string)$status
        );
    }
}
