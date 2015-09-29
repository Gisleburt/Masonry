<?php
/**
 * Pool.php
 * PHP version 5.4
 * 2015-09-29
 *
 * @package   Foundry\Masonry
 * @category  Core
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Core\Pool\Status;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\Task\StatusInterface as TaskStatus;
use Foundry\Masonry\Interfaces\TaskInterface;

/**
 * Class Pool
 *
 * @package Foundry\Masonry
 */
class Pool implements PoolInterface
{

    /**
     * @var TaskInterface[]
     */
    private $tasks = [];

    /**
     * Add a task to the pool.
     * @param TaskInterface $task
     * @return $this
     */
    public function addTask(TaskInterface $task)
    {
        if ($task->getStatus() != TaskStatus::STATUS_COMPLETE) {
            $this->tasks[] = $task;
        }
        return $this;
    }

    /**
     * Get the next task from the pool.
     * @return TaskInterface|null
     */
    public function getTask()
    {
        if ($this->tasks) {
            return array_shift($this->tasks);
        }
        return null;
    }

    /**
     * Get the current status of the pool.
     * This should allow 2 values:
     *   pending:  There are tasks pending
     *   empty:   There are no more tasks, the pool is empty
     * @return Task/Status
     */
    public function getStatus()
    {
        if ($this->tasks) {
            return new Status(Status::STATUS_PENDING);
        }
        return new Status(Status::STATUS_EMPTY);
    }
}
