<?php
/**
 * Worker.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/
 */


namespace Foundry\Masonry\Workers\Group\Parallel;

use Foundry\Masonry\Core\CoroutineRegister;
use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Interfaces\Pool\StatusInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Workers\Group\AbstractGroupWorker;
use React\Promise\Deferred;

/**
 * Class Worker
 *
 * @package Masonry
 * @see     https://github.com/Visionmongers/
 */
class Worker extends AbstractGroupWorker
{


    /**
     * Where the actual work is done
     * @param Deferred $deferred
     * @param TaskInterface $task
     * @return mixed
     */
    protected function processDeferred(Deferred $deferred, TaskInterface $task)
    {
        yield;

        /** @var Description $description */
        $description = $task->getDescription();

        try {
            $deferred->notify(Notification::normal("Processing parallel task group"));

            $coroutineRegister = new CoroutineRegister();

            $success = true;
            while ($description->getStatus() != StatusInterface::STATUS_EMPTY) {
                $this->processChildTask($description->getTask(), $success);
            }

            // Block until all tasks are complete
            while ($coroutineRegister->isValid()) {
                $coroutineRegister->tick();
                yield;
            }

            if ($success) {
                $deferred->resolve("Parallel tasks completed successfully");
                return;
            }

        } catch (\Exception $e) {
            $deferred->notify("Failed parallel tasks with exception: ".$e->getMessage());
        }
        $deferred->reject("Failed parallel tasks");
    }

    /**
     * Lists, as strings, the class/interface names this worker can handle.
     * Each worker should be responsible for one type of Task, however there might be multiple ways to describe the
     * task. The names of each possible description should be returned here.
     * @return string[]
     */
    public function getDescriptionTypes()
    {
        return [
            Description::class
        ];
    }
}
