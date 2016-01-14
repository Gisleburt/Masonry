<?php
/**
 * AbstractWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Core\Injection\HasLogger;
use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Interfaces\WorkerInterface;
use React\Promise\Deferred;

/**
 * Class AbstractWorker
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractWorker implements WorkerInterface
{

    use HasLogger;

    /**
     * Where the actual work is done
     * @param Deferred $deferred
     * @param TaskInterface $task
     * @return \Generator
     */
    abstract protected function processDeferred(Deferred $deferred, TaskInterface $task);

    /**
     * Set the task the worker needs to complete.
     * Returns a promise that can be used for asynchronous monitoring of progress.
     * @param TaskInterface $task
     * @return CoroutineInterface
     */
    public function process(TaskInterface $task)
    {
        $deferred = new Deferred();

        if (!$this->isTaskDescriptionValid($task)) {
            $deferred->reject('Invalid Task Description');

            // An invalid coroutine
            return new Coroutine(
                $deferred,
                null
            );
        }

        return new Coroutine(
            $deferred,
            $this->processDeferred($deferred, $task)
        );
    }

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
