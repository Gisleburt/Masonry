<?php
/**
 * Capability.php
 * PHP version 5.4
 * 2015-09-14
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

/**
 * Interface Capability
 * A capability is a requirement of a Task, or the ability of a Worker. For example, a task may require something like:
 * FileSystem::Move
 * This task will be assigned to a worker with this capability.
 * @package Foundry\Masonry
 */
interface Capability
{

    /**
     * Capability constructor.
     * @param string $capability
     */
    public function __construct($capability);

    /**
     * Returns the name of the capability
     * @return string
     */
    public function getCapability();

    /**
     * Should return the name of the capability for use in comparison.
     * @return string
     */
    public function __toString();

}