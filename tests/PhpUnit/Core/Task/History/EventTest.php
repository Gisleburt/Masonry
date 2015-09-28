<?php
/**
 * EventTest.php
 * PHP version 5.4
 * 2015-09-25
 *
 * @package   Foundry\Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core\Task\History;

use Foundry\Masonry\Core\Task\History\Event;
use Foundry\Masonry\Core\Task\History\Reason;
use Foundry\Masonry\Core\Task\History\Result;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class EventTest
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Task\History\Event
 */
class EventTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testConstruct()
    {
        $event = new Event();

        $this->assertGreaterThan(
            0,
            $event->getStartTime()
        );

        $this->assertTrue(
            is_float($event->getStartTime())
        );

        $this->assertEquals(
            0,
            $event->getEndTime()
        );
    }

    /**
     * @test
     * @covers ::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testEndEvent()
    {
        $event1 = new Event();
        $event1->endEvent(new Result(Result::RESULT_SUCCEEDED));

        $this->assertTrue(
            is_float($event1->getStartTime())
        );

        $this->assertGreaterThan(
            0,
            $event1->getStartTime()
        );

        $this->assertTrue(
            is_float($event1->getEndTime())
        );

        $this->assertGreaterThan(
            0,
            $event1->getEndTime()
        );
    }

    /**
     * @test
     * @covers ::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @return void
     */
    public function testGetStartTime()
    {
        $event = new Event();

        $this->assertTrue(
            is_float($event->getStartTime())
        );

        $this->assertGreaterThan(
            0,
            $event->getStartTime()
        );
    }

    /**
     * @test
     * @covers ::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testGetEndTime()
    {
        $event = new Event();

        $this->assertEquals(
            0,
            $event->getEndTime()
        );

        $event->endEvent(
            new Result(Result::RESULT_SUCCEEDED)
        );

        $this->assertGreaterThan(
            0,
            $event->getEndTime()
        );

        $this->assertGreaterThanOrEqual(
            $event->getStartTime(),
            $event->getEndTime()
        );
    }

    /**
     * @test
     * @covers ::getResult
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testGetResult()
    {
        $event = new Event();

        $this->assertSame(
            Result::RESULT_INCOMPLETE,
            (string)$event->getResult()
        );

        $event->endEvent(new Result(Result::RESULT_FAILED));

        $this->assertSame(
            Result::RESULT_FAILED,
            (string)$event->getResult()
        );
    }

    /**
     * @test
     * @covers ::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testGetReason()
    {
        $event = new Event();
        $reason = 'Test Reason';

        $this->assertSame(
            '',
            (string)$event->getReason()
        );

        $event->endEvent(
            new Result(Result::RESULT_FAILED),
            new Reason($reason)
        );

        $this->assertSame(
            $reason,
            (string)$event->getReason()
        );
    }

    /**
     * @test
     * @covers ::__toString
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Event::getResult
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testToString()
    {
        $event = new Event();
        $event->endEvent(
            new Result(Result::RESULT_SUCCEEDED),
            new Reason('Test Reason')
        );

        $this->assertRegExp(
            '/\[[\d\.]+ - [\d\.]+\]\['.Result::RESULT_SUCCEEDED.'\] Test Reason/',
            (string)$event
        );

    }

}