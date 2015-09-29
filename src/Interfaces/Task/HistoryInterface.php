<?php
/**
 * History.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Interfaces
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

use Foundry\Masonry\Interfaces\Task\History\EventInterface;

/**
 * Interface HistoryInterface
 * Represents the history of a task
 * @package Foundry\Masonry
 */
interface HistoryInterface
{

    /**
     * Add an event to the history
     * @param EventInterface $event
     * @return $this
     */
    public function addEvent(EventInterface $event);

    /**
     * Returns all events in the history
     * @return EventInterface[]
     */
    public function getEvents();

    /**
     * Returns the last event in the history, or null if nothing has happened yet
     * @return EventInterface
     */
    public function getLastEvent();
}
