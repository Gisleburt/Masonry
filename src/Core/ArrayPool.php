<?php
/**
 * ArrayPool.php
 * PHP version 5.4
 * 2015-09-29
 *
 * @package   Foundry\Masonry
 * @category  Core
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */

namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;

/**
 * Class Pool
 *
 * @package Foundry\Masonry
 */
class ArrayPool extends Pool
{

    /**
     * YamlQueue constructor.
     * @param array $tasks Things that might be tasks
     */
    public function __construct(array $tasks)
    {

        foreach ($tasks as $name => $parameters) {
            if ($parameters instanceof TaskInterface) {
                $this->addTask($parameters);
                continue;
            }
            if ($parameters instanceof DescriptionInterface) {
                $this->addTask(new Task($parameters));
                continue;
            }
            $this->addPotentialTask($name, $parameters);
        }
    }

    /**
     * Try to add a task
     * @param $taskName
     * @param $taskParameters
     * @return $this
     */
    protected function addPotentialTask($taskName, $taskParameters)
    {
        $moduleRegister = GlobalRegister::getModuleRegister();
        $className = '';
        try {
            list($module, $descriptionAlias) = explode('/', $taskName);

            if ($module && $descriptionAlias) {
                $className = $moduleRegister->getWorkerModule($module)->lookupDescription($descriptionAlias);
            }

        } catch (\Exception $e) {
            // Do nothing
        }

        if (!class_exists($className)) {
            if (is_array($taskParameters)) {
                foreach ($taskParameters as $name => $parameters) {
                    $this->addPotentialTask($name, $parameters);
                }
                return $this;
            }
            throw new \UnexpectedValueException("'{$taskName}' did not match a class");
        }

        /** @var AbstractDescription $className */
        $description = $className::createFromParameters($taskParameters);

        if (!$description instanceof DescriptionInterface) {
            throw new \RuntimeException("'{$className}' was not a description");
        }

        return $this->addTask(new Task($description));
    }
}
