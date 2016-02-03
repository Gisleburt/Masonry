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
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Core\Task\History\Reason;
use Foundry\Masonry\Core\Task\History\Result;
use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\NotificationInterface;
use Foundry\Masonry\Interfaces\Task\History\ResultInterface;
use Foundry\Masonry\Interfaces\TaskInterface;

/**
 * Abstract Class GroupWorker
 * Knows about mediators and coroutines
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractGroupWorker extends AbstractWorker
{

    /**
     * Fins the correct worker using the mediator and sets up the promise callbacks.
     * @param TaskInterface $task
     * @return CoroutineInterface
     */
    public function processChildTask(TaskInterface $task)
    {
        $task->start();
        $mediator = GlobalRegister::getMediator();

        $coroutine = $mediator->process($task);

        $coroutine->getPromise()

            // On success
            ->then(function ($notification) use (&$task) {
                if (!$notification instanceof NotificationInterface) {
                    // Success messages can be switched off with quiet
                    $notification = Notification::normal($notification);
                }
                $task->complete(
                    new Result(ResultInterface::RESULT_SUCCEEDED),
                    new Reason($notification)
                );
                $this->getLogger()->info($notification);
            })

            // On failure
            ->otherwise(function ($notification) use (&$task) {
                if (!$notification instanceof NotificationInterface) {
                    // Failures should always show
                    $notification = Notification::high($notification);
                }
                $task->complete(
                    new Result(ResultInterface::RESULT_FAILED),
                    new Reason($notification)
                );
                $this->getLogger()->error($notification);
            })

            // When something happens
            ->progress(function ($message) {
                if (!$message instanceof NotificationInterface) {
                    // Only log progress when being verbose
                    $message = Notification::info($message);
                }
                $this->getLogger()->notice($message);
            });

        return $coroutine;
    }
}
