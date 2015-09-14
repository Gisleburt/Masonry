<?php
/**
 * Task.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;


interface Task
{

    /**
     * The capabilities required to fulfill the task.
     * Best practice is to try to make each task require a single capability.
     * @return Value\Capability[]
     */
    public function getRequiredCapabilities();

    /**
     * Returns the data for the worker to use.
     * This data is generally bespoke.
     * @return Value\TaskDescription
     */
    public function getDescription();

}