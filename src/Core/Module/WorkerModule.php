<?php
/**
 * Module.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core\Module;

use Foundry\Masonry\Core\Mediator;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Class Module
 * A module is a collection of Workers that can be imported in to any Masonry implementation to deal with tasks.
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
class WorkerModule extends Mediator implements WorkerModuleInterface
{

    /**
     * @var DescriptionInterface[]
     */
    protected $descriptionTypes = [];

    /**
     * Module constructor.
     * Workers can be initialised here.
     * @param array $workers
     */
    public function __construct(array $workers)
    {
        foreach ($workers as $worker) {
            $this->addWorker($worker);
        }
    }

    /**
     * Lists, as strings, the class/interface names this module can handle.
     * @see Foundry\Masonry\Interfaces\WorkerInterface::getDescriptionTypes
     * @return DescriptionInterface[]
     */
    public function getDescriptionTypes()
    {
        if (!$this->descriptionTypes) {
            foreach ($this->workers as $worker) {
                $workerDescriptionTypes = $worker->getDescriptionTypes();
                foreach ($workerDescriptionTypes as $descriptionType) {
                    $this->descriptionTypes[$descriptionType] = $descriptionType;
                }
            }
        }
        return $this->descriptionTypes;
    }
}
