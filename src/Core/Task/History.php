<?php
/**
 * History.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Core
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core\Task;

use Foundry\Masonry\Interfaces\Task\History\EventInterface;

/**
 * Class History
 * Represents the history of a task
 * @package Foundry\Masonry
 */
class History
{

    private $events = [];

    /**
     * Add an event to the history
     * @param EventInterface $event
     * @return $this
     */
    public function addEvent(EventInterface $event)
    {
        $this->events[] = $event;
    }

    /**
     * Returns all events in the history
     * @return EventInterface[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Returns the last event in the history, or null if nothing has happened yet
     * @return EventInterface
     */
    public function getLastEvent()
    {
        return end($this->events);
    }
}
