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
use Foundry\Masonry\Core\Mediator;
use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Interfaces\MediatorAwareInterface;
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

    use Mediator\MediatorAwareTrait;

    /**
     * Fins the correct worker using the mediator and sets up the promise callbacks.
     * @param TaskInterface $task
     * @param $success
     * @return void
     */
    protected function mediate(TaskInterface $task, &$success)
    {
        $mediator = $this->getMediator();

        $mediator
            ->process($task)

            // On success
            ->then(function ($result) use (&$success) {
                if (!$result instanceof NotificationInterface) {
                    // Success messages can be switched off with quiet
                    $result = Notification::normal($result);
                }
                $success = true;
                $this->getLogger()->info($result);
            })

            // On failure
            ->otherwise(function ($result) use (&$success) {
                if (!$result instanceof NotificationInterface) {
                    // Failures should always show
                    $result = Notification::high($result);
                }
                $success = false; // Fail
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
    }
}
