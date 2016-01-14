<?php
/**
 * Worker.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Workers\Masonry;

use Foundry\Masonry\Core\Mediator;
use Foundry\Masonry\Core\Task;
use Foundry\Masonry\Workers\Group\Serial\Worker as SerialWorker;
use Foundry\Masonry\Workers\Group\Serial\Description as SerialDescription;
use Foundry\Masonry\Interfaces\TaskInterface;
use React\Promise\Deferred;

/**
 * Class Worker
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Worker extends SerialWorker
{
    /**
     * @param Deferred $deferred
     * @param TaskInterface $task
     * @return \Generator
     */
    protected function processDeferred(Deferred $deferred, TaskInterface $task)
    {
        /** @var Description $description */
        $description = $task->getDescription();

        $mediator = new Mediator();
        foreach ($description->getWorkerModules() as $workerModule) {
            $mediator->addWorker($workerModule);
        }
        $this->setMediator($mediator);

        $childDescription = new SerialDescription($description->getPool());
        $childTask = new Task($childDescription);

        return parent::processDeferred($deferred, $childTask);
    }

    /**
     * @return array
     */
    public function getDescriptionTypes()
    {
        return [
            Description::class
        ];
    }
}
