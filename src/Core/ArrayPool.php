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

/**
 * Class Pool
 *
 * @package Foundry\Masonry
 */
class ArrayPool extends Pool
{

    /**
     * ArrayPool constructor.
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
        $className = $this->getTaskClassName($taskName);

        if (!class_exists($className)) {
            if (is_array($taskParameters)) {
                foreach ($taskParameters as $name => $parameters) {
                    $this->addPotentialTask($name, $parameters);
                }
                return $this;
            }
            throw new \UnexpectedValueException("'{$taskName}' did not match a class");
        }

        $reflectionClass = new \ReflectionClass($className);
        if (!in_array(DescriptionInterface::class, $reflectionClass->getInterfaceNames())) {
            throw new \RuntimeException("'{$className}' was not a description");
        }

        /** @var AbstractDescription $className */
        $description = $className::createFromParameters($taskParameters);

        $this->addTask(new Task($description));
        return $this;
    }

    /**
     * Attempt to identify the task class from the given name.
     * If the class is found its name is returned as a string. If not, null is returned.
     * @param $taskName
     * @return string|null
     */
    protected function getTaskClassName($taskName)
    {
        $moduleRegister = GlobalRegister::getModuleRegister();
        try {
            // Split on \, /, |, or :
            list($module, $descriptionAlias) = preg_split('!\\\|/|\||:!', $taskName, 2);

            if ($module && $descriptionAlias) {
                return $moduleRegister->getWorkerModule($module)->lookupDescription($descriptionAlias);
            }

        } catch (\Exception $e) {
            // Do nothing
        }
        return null;
    }
}
