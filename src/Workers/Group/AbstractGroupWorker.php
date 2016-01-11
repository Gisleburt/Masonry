<?php
/**
 * AbstractGroupWorker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Workers\Group;

use Foundry\Masonry\Core\AbstractWorker;
use Foundry\Masonry\Core\Mediator\MediatorAwareTrait;
use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Core\Task\Status;
use Foundry\Masonry\Interfaces\Mediator\MediatorAwareInterface;
use Foundry\Masonry\Interfaces\NotificationInterface;
use Foundry\Masonry\Interfaces\TaskInterface;

/**
 * Abstract Class GroupWorker
 * Knows about mediators and coroutines
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractGroupWorker extends AbstractWorker implements MediatorAwareInterface
{

    use MediatorAwareTrait;

    /**
     * Fins the correct worker using the mediator and sets up the promise callbacks.
     * @param TaskInterface $task
     * @return Status
     */
    public function processTask(TaskInterface $task)
    {
        $status = new Status(Status::STATUS_IN_PROGRESS);
        $mediator = $this->getMediator();

        $mediator
            ->process($task)

            // On success
            ->then(function ($result) use (&$status) {
                if (!$result instanceof NotificationInterface) {
                    // Success messages can be switched off with quiet
                    $result = Notification::normal($result);
                }
                $status = new Status(Status::STATUS_COMPLETE);
                $this->getLogger()->info($result);
            })

            // On failure
            ->otherwise(function ($result) use (&$status) {
                if (!$result instanceof NotificationInterface) {
                    // Failures should always show
                    $result = Notification::high($result);
                }
                $status = new Status(Status::STATUS_FAILED);
                $this->getLogger()->error($result);
            })

            // When something happens
            ->progress(function ($result) {
                if (!$result instanceof NotificationInterface) {
                    // Only log progress when being verbose
                    $result = Notification::info($result);
                }
                $this->getLogger()->notice($result);
            });

        return $status;
    }
}
