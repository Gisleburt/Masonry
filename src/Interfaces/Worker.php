<?php
/**
 * Worke.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;

use React\Promise\Promise;

interface Worker
{

    /**
     * Set the task the worker needs to complete.
     * Returns a promise that can be used for asynchronous monitoring of progress.
     * @param Task $task
     * @return Promise
     */
    public function process(Task $task);

    /**
     * Lists, as strings, the class/interface names this worker can handle.
     * Each worker should be responsible for one type of Task, however there might be multiple ways to describe the
     * task. The names of each possible description should be returned here.
     * @return string[]
     */
    public function getDescriptionTypes();
}
