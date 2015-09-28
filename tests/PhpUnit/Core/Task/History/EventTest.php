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
     * @covers ::startEvent
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @return void
     */
    public function testStartEvent()
    {
        $event = Event::startEvent();

        $this->assertTrue(
            $event->getStartTime()
        );

        $this->assertTrue(
            is_float($event->getStartTime())
        );

        $this->assertFalse(
            $event->getEndTime()
        );
    }

    /**
     * @test
     * @covers ::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @return void
     */
    public function testEndEvent()
    {
        $event1 = Event::startEvent();
        $event1->endEvent(new Result(Result::RESULT_SUCCEEDED));

        $this->assertTrue(
            is_float($event1->getStartTime())
        );

        $this->assertTrue(
            $event1->getStartTime() > 0
        );

        $this->assertTrue(
            is_float($event1->getEndTime())
        );

        $this->assertTrue(
            $event1->getEndTime() > 0
        );
    }

    /**
     * @test
     * @covers ::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @return void
     */
    public function testGetStartTime()
    {
        $event = Event::startEvent();

        $this->assertTrue(
            $event->getStartTime()
        );

        $this->assertTrue(
            is_float($event->getStartTime())
        );

        $this->assertTrue(
            $event->getStartTime() > 0
        );
    }

    /**
     * @test
     * @covers ::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @return void
     */
    public function testGetEndTime()
    {
        $event = Event::startEvent();

        $this->assertFalse(
            $event->getEndTime()
        );

        $event->endEvent(
            new Result(Result::RESULT_SUCCEEDED)
        );

        $this->assertTrue(
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
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @return void
     */
    public function testGetResult()
    {
        $event = Event::startEvent();

        $this->assertSame(
            Result::RESULT_INCOMPLETE,
            (string)$event->getResult()
        );

        $event->endEvent(new Result(Result::RESULT_FAILED));

        $this->assertSame(
            Result::RESULT_FAILED,
            $event->getResult()
        );
    }

    /**
     * @test
     * @covers ::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testGetReason()
    {
        $event = Event::startEvent();
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
     * @covers ::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Event::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Event::startEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::endEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testToString()
    {
        $event = Event::startEvent();
        $event->endEvent(
            new Result(Result::RESULT_SUCCEEDED),
            new Reason('Test Reason')
        );

        $this->assertRegExp(
            '/\[\d + \d+]\['.Result::RESULT_SUCCEEDED.'\] Test Reason',
            (string)$event
        );

    }

}