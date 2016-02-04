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

    /**
     * Sets the value of a static attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @param string $className
     * @param string $attributeName
     *
     * @return void
     *
     * @throws \PHPUnit_Framework_Exception
     *
     * @since  Method available since Release 4.0.0
     */
    public static function setStaticAttribute($className, $attributeName, $value)
    {
        if (!is_string($className)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'string');
        }

        if (!class_exists($className)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(1, 'class name');
        }

        if (!is_string($attributeName)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(2, 'string');
        }

        if (!preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $attributeName)) {
            throw \PHPUnit_Util_InvalidArgumentHelper::factory(2, 'valid attribute name');
        }

        $class = new \ReflectionClass($className);

        while ($class) {
            $attributes = $class->getStaticProperties();

            if (array_key_exists($attributeName, $attributes)) {
                $reflectedProperty = $class->getProperty($attributeName);
                $reflectedProperty->setAccessible(true);
                $reflectedProperty->setValue($value);
                return;
            }

            $class = $class->getParentClass();
        }

        throw new \PHPUnit_Framework_Exception(
            sprintf(
                'Attribute "%s" not found in class.',
                $attributeName
            )
        );
    }
}
