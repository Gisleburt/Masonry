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

use Foundry\Masonry\Interfaces\Value\Reason;
use Foundry\Masonry\Interfaces\Value\Status;

/**
 * Interface Pool
 * Describes the pool in which Tasks are kept.
 * This could be a database, a queue, a file, or something else.
 * @package Foundry\Masonry\Interfaces
 */
interface Pool
{

    const STATUS_ACTIVE  = 'active';
    const STATUS_WAITING = 'waiting';
    const STATUS_EMPTY   = 'empty';

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
     * Once a task is complete, tell the pool to close it.
     * @param Task $task
     * @param Reason $reason
     * @return $this
     */
    public function closeTask(Task $task, Reason $reason);

    /**
     * Tasks can be added back to the pool to be processed again later.
     * This could be because information in the task has change, or because the task could not be completed now.
     * @param Task $task
     * @param Reason $reason
     * @return $this
     */
    public function returnTask(Task $task, Reason $reason);

    /**
     * Get the current status of the pool.
     * This should allow 3 values:
     *   active:  There are tasks pending
     *   waiting: There are no tasks now, but more are expected
     *   empty:   There are no more tasks, the pool is empty
     * @return Status
     */
    public function getStatus();

}