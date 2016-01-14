<?php
/**
 * MediatorAwareTraitTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Interfaces\Mediator\MediatorAwareInterface;
use Foundry\Masonry\Interfaces\MediatorInterface;

/**
 * Trait MediatorAwareTraitTest
 * Add this trait to classes that are MediatorAware
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait MediatorAwareTraitTest
{

    /**
     * Returns a mock object for the specified abstract class with all abstract
     * methods of the class mocked. Concrete methods are not mocked by default.
     * To mock concrete methods, use the 7th parameter ($mockedMethods).
     *
     * @see \PHPUnit_Framework_TestCase
     *
     * @param string $originalClassName
     * @param array  $arguments
     * @param string $mockClassName
     * @param bool   $callOriginalConstructor
     * @param bool   $callOriginalClone
     * @param bool   $callAutoload
     * @param array  $mockedMethods
     * @param bool   $cloneArguments
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     *
     * @since  Method available since Release 3.4.0
     *
     * @throws \PHPUnit_Framework_Exception
     */
    abstract public function getMockForAbstractClass(
        $originalClassName,
        array $arguments = [],
        $mockClassName = '',
        $callOriginalConstructor = true,
        $callOriginalClone = true,
        $callAutoload = true,
        $mockedMethods = [],
        $cloneArguments = false
    );


    /**
     * Asserts that a variable is null.
     *
     * @see \PHPUnit_Framework_Assert
     *
     * @param mixed  $actual
     * @param string $message
     */
    abstract public function assertNull($actual, $message = '');

    /**
     * Asserts that two variables have the same type and value.
     * Used on objects, it asserts that two variables reference
     * the same object.
     *
     * @see \PHPUnit_Framework_Assert
     *
     * @param mixed  $expected
     * @param mixed  $actual
     * @param string $message
     */
    abstract public function assertSame($expected, $actual, $message = '');

    /**
     * Gets returns a proxy for any method of an object, regardless of scope
     * @see Foundry\Masonry\Tests\PhpUnit\TestCase
     * @param object $object Any object
     * @param string $methodName The name of the method you want to proxy
     * @return callable
     */
    abstract protected function getObjectMethod($object, $methodName);

    /**
     * @return MediatorAwareInterface
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::setMediator
     * @covers ::getMediator
     */
    public function testGetAndSetMediator()
    {
        /** @var MediatorInterface|\PHPUnit_Framework_MockObject_MockObject $mediator */
        $mediator = $this->getMockForAbstractClass(MediatorInterface::class);
        $testSubject = $this->getTestSubject();

        $getMediator = $this->getObjectMethod($testSubject, 'getMediator');

        $this->assertNull(
            $getMediator()
        );

        $this->assertSame(
            $testSubject,
            $testSubject->setMediator($mediator)
        );

        $this->assertSame(
            $mediator,
            $getMediator()
        );
    }


}
