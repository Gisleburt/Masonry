<?php
/**
 * TestCase.php
 * PHP version 5.4
 * 2015-09-14
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit;

use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\TaskInterface;

/**
 * Class TestCase
 *
 * @package Foundry\Masonry\Tests\PhpUnit
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * Gets returns a proxy for any method of an object, regardless of scope
     * @param object $object Any object
     * @param string $methodName The name of the method you want to proxy
     * @return \Closure
     */
    protected function getObjectMethod($object, $methodName)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Can not get method of non object');
        }
        $reflectionMethod = new \ReflectionMethod($object, $methodName);
        $reflectionMethod->setAccessible(true);
        return function () use ($object, $reflectionMethod) {
            return $reflectionMethod->invokeArgs($object, func_get_args());
        };
    }

    /**
     * Set the attribute of an object to a particular value
     * @param object $object        The object on which the value will be changed
     * @param string $attributeName The name of the attribute to change
     * @param mixed  $value         The value to change the attribute to
     */
    protected function setObjectAttribute($object, $attributeName, &$value)
    {
        $objectReflection = new \ReflectionObject($object);
        $property = $objectReflection->getProperty($attributeName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * @return TaskInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockTask()
    {
        $task =
            $this
                ->getMockBuilder(TaskInterface::class)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();
        return $task;
    }

    /**
     * @return CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockCoroutine()
    {
        $task =
            $this
                ->getMockBuilder(CoroutineInterface::class)
                ->disableOriginalConstructor()
                ->getMockForAbstractClass();
        return $task;
    }
}
