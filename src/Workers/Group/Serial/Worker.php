<?php
/**
 * Worker.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/
 */


namespace Foundry\Masonry\Workers\Group\Serial;

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

        /** @var DescriptionAbstract $description */
        $description = $task->getDescription();

        try {
            $deferred->notify(Notification::normal("Processing serial task group"));

            $coroutineRegister = new CoroutineRegister();

            $success = true;
            while ($success && $description->getStatus() != StatusInterface::STATUS_EMPTY) {
                $this->mediate($description->getTask(), $success);

                // Block progress until the coroutine is finished
                while ($coroutineRegister->isValid()) {
                    $coroutineRegister->tick();
                    yield;
                }

            }

            if ($success) {
                $deferred->resolve("Serial tasks completed successfully");
                return;
            }

        } catch (\Exception $e) {
            $deferred->notify("Failed serial tasks with exception: ".$e->getMessage());
        }

        $deferred->reject("Failed serial tasks");
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
            DescriptionAbstract::class
        ];
    }
}
