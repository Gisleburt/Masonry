<?php
/**
 * AbstractCoroutineWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use React\Promise\Deferred;


/**
 * Class AbstractCoroutineWorker
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractCoroutineWorker extends AbstractWorker implements CoroutineInterface
{

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

}
