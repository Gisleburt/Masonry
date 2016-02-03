<?php
/**
 * Mediator.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Interfaces
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;

use React\Promise\Promise;

/**
 * Interface MediatorInterface
 *
 * @package Foundry\Masonry
 */
interface MediatorInterface
{

    /**
     * Inform the Mediator about a Worker
     * @param WorkerInterface $worker
     * @return $this
     */
    public function addWorker(WorkerInterface $worker);

    /**
     * Process a given task, returning the coroutine from the worker that took it. If no appropriate
     * task is found, an Exception will be thrown instead.
     * @param TaskInterface $task
     * @throws \OutOfBoundsException
     * @return CoroutineInterface
     */
    public function process(TaskInterface $task);
}
