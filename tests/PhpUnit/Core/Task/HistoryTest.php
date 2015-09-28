<?php
/**
 * StatusInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

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
     * @return void
     */
    public function testAddEvent()
    {
        $event = History\Event::startEvent();
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
     * @return void
     */
    public function testGetEvents()
    {
        $event = History\Event::startEvent();
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
     * @return void
     */
    public function tetGetLastEvent()
    {
        $event = History\Event::startEvent();
        $history = new History();
        $history->addEvent($event);

        $this->assertSame(
            $event,
            $history->getLastEvent()
        );
    }
}
