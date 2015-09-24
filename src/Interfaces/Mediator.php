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

interface Mediator
{

    /**
     * Inform the Mediator about a Worker
     * @param Worker $worker
     * @return $this
     */
    public function addWorker(Worker $worker);

    /**
     * Process a given task, returning the promise from the worker that took it. If no appropriate
     * task is found, an Exception will be thrown instead.
     * @param Task $task
     * @throws \Exception
     * @return Promise
     */
    public function process(Task $task);
}
