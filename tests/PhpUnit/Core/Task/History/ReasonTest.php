<?php
/**
 * ReasonTest.php
 * PHP version 5.4
 * 2015-09-25
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core\Task\History;

use Foundry\Masonry\Core\Task\History\Reason;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class ReasonTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Task\History\Reason
 */
class ReasonTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Reason::getReason
     * @return void
     */
    public function testConstruct()
    {
        $reason = new Reason('Reason');

        $this->assertNotEmpty(
            $reason->getReason()
        );

        $this->assertSame(
            'Reason',
            $reason->getReason()
        );
    }

    /**
     * @test
     * @covers ::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Reason::__construct
     * @return void
     */
    public function testGetResult()
    {
        $reason = new Reason('Reason');

        $this->assertNotEmpty(
            $reason->getReason()
        );

        $this->assertSame(
            'Reason',
            $reason->getReason()
        );
    }

    /**
     * @test
     * @covers ::__toString
     * @uses \Foundry\Masonry\Core\Task\History\Reason::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Reason::getReason
     * @return void
     */
    public function testToString()
    {
        $reason = new Reason('Reason');

        $this->assertNotEmpty(
            $reason->getReason()
        );

        $this->assertSame(
            'Reason',
            $reason->__toString()
        );

        $this->assertSame(
            'Reason',
            (string)$reason
        );
    }
}
