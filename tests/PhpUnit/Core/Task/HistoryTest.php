<?php
/**
 * HistoryTest.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core\Task;

use Foundry\Masonry\Core\Task\History;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class HistoryTest
 * @package Foundry\Masonry\Interfaces\Task
 * @coversDefaultClass \Foundry\Masonry\Core\Task\History
 */
class HistoryTest extends TestCase
{

    /**
     * @test
     * @covers ::addEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\History::getLastEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testAddEvent()
    {
        $event = new History\Event();
        $history = new History();
        $history->addEvent($event);

        $this->assertSame(
            $event,
            $history->getLastEvent()
        );
    }

    /**
     * @test
     * @covers ::getEvents
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\History::addEvent
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function testGetEvents()
    {
        $event = new History\Event();
        $history = new History();
        $history->addEvent($event);

        $this->assertSame(
            [$event],
            $history->getEvents()
        );
    }

    /**
     * @test
     * @covers ::getLastEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event
     * @uses \Foundry\Masonry\Core\Task\History::addEvent
     * @uses \Foundry\Masonry\Core\Task\History\Event::getStartTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getEndTime
     * @uses \Foundry\Masonry\Core\Task\History\Event::getResult
     * @uses \Foundry\Masonry\Core\Task\History\Event::getReason
     * @uses \Foundry\Masonry\Core\Task\History\Result
     * @uses \Foundry\Masonry\Core\Task\History\Reason
     * @return void
     */
    public function tetGetLastEvent()
    {
        $event = new History\Event();
        $history = new History();
        $history->addEvent($event);

        $this->assertSame(
            $event,
            $history->getLastEvent()
        );
    }
}
