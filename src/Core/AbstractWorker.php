<?php
/**
 * AbstractWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Interfaces\WorkerInterface;


/**
 * Class AbstractWorker
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractWorker implements WorkerInterface
{

    /**
     * Check if the worker can process the task
     * @param TaskInterface $task
     * @return bool
     */
    protected function isTaskDescriptionValid(TaskInterface $task)
    {
        foreach ($this->getDescriptionTypes() as $type) {
            if ($task->getDescription() instanceof $type) {
                return true;
            }
        }
        return false;
    }

}
