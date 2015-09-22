<?php

/**
 * Pool.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */

namespace Foundry\Masonry\Interfaces;

use Foundry\Masonry\Interfaces\Pool\Status;

/**
 * Interface Pool
 * Describes the pool in which Tasks are kept.
 * This could be a database, a queue, a file, or something else.
 * @package Foundry\Masonry
 */
interface Pool
{

    /**
     * Get the next task from the pool.
     * @return Task
     */
    public function getTask();

    /**
     * Add a task to the pool.
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task);

    /**
     * Get the current status of the pool.
     * This should allow 3 values:
     *   pending:  There are tasks pending
     *   empty:   There are no more tasks, the pool is empty
     * @return Status
     */
    public function getStatus();

}