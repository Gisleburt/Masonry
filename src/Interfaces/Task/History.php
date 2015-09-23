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

use Foundry\Masonry\Interfaces\Task\History\Event;

/**
 * Interface Status
 * Represents the current status of a Pool
 * @package Foundry\Masonry
 */
interface History
{

    /**
     * Add an event to the history
     * @param Event $event
     * @return $this
     */
    public function addEvent(Event $event);

    /**
     * Returns all events in the history
     * @return Event[]
     */
    public function getEvents();

    /**
     * Returns the last event in the history, or null if nothing has happened yet
     * @return Event
     */
    public function getLastEvent();
}