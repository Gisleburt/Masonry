<?php
/**
 * TestCaseTrait.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
namespace Foundry\Masonry\Tests\PhpUnit;

use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\TaskInterface;
use Foundry\Masonry\Tests\PhpUnit\PhpUnitHelper\TestCaseTrait as PhpUnitTestCaseTrait;

/**
 * Class TestCase
 *
 * @package Foundry\Masonry\Tests\PhpUnit
 */
trait TestCaseTrait
{

    use PhpUnitTestCaseTrait;

    /**
     * Gets returns a proxy for any method of an object, regardless of scope
     * @param object $object Any object
     * @param string $methodName The name of the method you want to proxy
     * @return \Closure
     */
    abstract protected function getObjectMethod($object, $methodName);

    /**
     * Set the attribute of an object to a particular value
     * @param object $object        The object on which the value will be changed
     * @param string $attributeName The name of the attribute to change
     * @param mixed  $value         The value to change the attribute to
     */
    abstract protected function setObjectAttribute($object, $attributeName, &$value);

    /**
     * @return TaskInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    abstract protected function getMockTask();

    /**
     * @return CoroutineInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    abstract protected function getMockCoroutine();
}
