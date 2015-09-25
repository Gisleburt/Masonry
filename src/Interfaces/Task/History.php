<?php
/**
 * Status.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

use Foundry\Masonry\Interfaces\Task\History\EventInterface;

/**
 * Interface Status
 * Represents the current status of a Pool
 * @package Foundry\Masonry
 */
interface History
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
