<?php
/**
 * AbstractGroupDescription.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/
 */


namespace Foundry\Masonry\Workers\Group;

use Foundry\Masonry\Core\AbstractDescription;
use Foundry\Masonry\Interfaces\Pool\StatusInterface;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\TaskInterface;

/**
 * Abstract Class Description
 *
 * @package Masonry
 * @see     https://github.com/Visionmongers/
 */
abstract class AbstractGroupDescription extends AbstractDescription implements PoolInterface
{
    /**
     * @var PoolInterface
     */
    protected $pool;

    /**
     * Description constructor.
     * @param PoolInterface $pool
     */
    public function __construct(PoolInterface $pool)
    {
        $this->pool = $pool;
    }

    /**
     * @param TaskInterface $task
     * @return $this
     */
    public function addTask(TaskInterface $task)
    {
        $this->pool->addTask($task);
        return $this;
    }

    /**
     * @return TaskInterface|null
     */
    public function getTask()
    {
        return $this->pool->getTask();
    }


    /**
     * @return StatusInterface
     */
    public function getStatus()
    {
        return $this->pool->getStatus();
    }
}
