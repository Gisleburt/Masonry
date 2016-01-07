<?php
/**
 * Mediator.php
 * PHP version 5.4
 * 2015-09-29
 *
 * @package   Foundry\Masonry
 * @category  Core
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Core\Exception\NoWorkerFound;
use Foundry\Masonry\Interfaces\MediatorInterface;
use Foundry\Masonry\Interfaces\WorkerInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use React\Promise\Promise;

/**
 * Class Mediator
 * Mediates between tasks and workers (i.e. finds the right worker for a given task)
 * @package Foundry\Masonry
 */
class Mediator implements MediatorInterface
{

    /**
     * @var WorkerInterface[]
     */
    protected $workers = [];

    /**
     * Inform the Mediator about a Worker
     * @param WorkerInterface $worker
     * @return $this
     */
    public function addWorker(WorkerInterface $worker)
    {
        $this->workers[] = $worker;
        return $this;
    }

    /**
     * Process a given task, returning the promise from the worker that took it. If no appropriate
     * task is found, an Exception will be thrown instead.
     * @param TaskInterface $task
     * @throws NoWorkerFound
     * @return Promise
     */
    public function process(TaskInterface $task)
    {
        foreach ($this->workers as $worker) {
            foreach ($worker->getDescriptionTypes() as $descriptionType) {
                if ($task->getDescription() instanceof $descriptionType) {
                    return $worker->process($task);
                }
            }
        }
        throw new NoWorkerFound();
    }
}
