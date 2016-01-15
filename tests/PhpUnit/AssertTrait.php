<?php
/**
 * AssertTrait.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
namespace Foundry\Masonry\Tests\PhpUnit;

use ArrayAccess;
use Countable;
use DOMElement;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Constraint;
use PHPUnit_Framework_Constraint_And;
use PHPUnit_Framework_Constraint_ArrayHasKey;
use PHPUnit_Framework_Constraint_Attribute;
use PHPUnit_Framework_Constraint_Callback;
use PHPUnit_Framework_Constraint_ClassHasAttribute;
use PHPUnit_Framework_Constraint_ClassHasStaticAttribute;
use PHPUnit_Framework_Constraint_Count;
use PHPUnit_Framework_Constraint_FileExists;
use PHPUnit_Framework_Constraint_GreaterThan;
use PHPUnit_Framework_Constraint_IsAnything;
use PHPUnit_Framework_Constraint_IsEmpty;
use PHPUnit_Framework_Constraint_IsEqual;
use PHPUnit_Framework_Constraint_IsFalse;
use PHPUnit_Framework_Constraint_IsFinite;
use PHPUnit_Framework_Constraint_IsIdentical;
use PHPUnit_Framework_Constraint_IsInfinite;
use PHPUnit_Framework_Constraint_IsInstanceOf;
use PHPUnit_Framework_Constraint_IsJson;
use PHPUnit_Framework_Constraint_IsNan;
use PHPUnit_Framework_Constraint_IsNull;
use PHPUnit_Framework_Constraint_IsTrue;
use PHPUnit_Framework_Constraint_IsType;
use PHPUnit_Framework_Constraint_LessThan;
use PHPUnit_Framework_Constraint_Not;
use PHPUnit_Framework_Constraint_ObjectHasAttribute;
use PHPUnit_Framework_Constraint_Or;
use PHPUnit_Framework_Constraint_PCREMatch;
use PHPUnit_Framework_Constraint_StringContains;
use PHPUnit_Framework_Constraint_StringEndsWith;
use PHPUnit_Framework_Constraint_StringMatches;
use PHPUnit_Framework_Constraint_StringStartsWith;
use PHPUnit_Framework_Constraint_TraversableContains;
use PHPUnit_Framework_Constraint_TraversableContainsOnly;
use PHPUnit_Framework_Constraint_Xor;
use PHPUnit_Framework_Exception;
use PHPUnit_Framework_IncompleteTestError;
use PHPUnit_Framework_SkippedTestError;
use Traversable;


/**
 * A set of assert methods.
 *
 * @since Class available since Release 2.0.0
 */
trait AssertTrait
{
    /**
     * Asserts that an array has a specified key.
     *
     * @param mixed $key
     * @param array|ArrayAccess $array
     * @param string $message
     *
     * @since Method available since Release 3.0.0
     */
    abstract public function assertArrayHasKey($key, $array, $message = '');

    /**
     * Asserts that an array has a specified subset.
     *
     * @param array|ArrayAccess $subset
     * @param array|ArrayAccess $array
     * @param bool $strict Check for object identity
     * @param string $message
     *
     * @since Method available since Release 4.4.0
     */
    abstract public function assertArraySubset($subset, $array, $strict = false, $message = '');

    /**
     * Asserts that an array does not have a specified key.
     *
     * @param mixed $key
     * @param array|ArrayAccess $array
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertArrayNotHasKey($key, $array, $message = '');

    /**
     * Asserts that a haystack contains a needle.
     *
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since  Method available since Release 2.1.0
     */
    abstract public function assertContains(
        $needle,
        $haystack,
        $message = '',
        $ignoreCase = false,
        $checkForObjectIdentity = true,
        $checkForNonObjectIdentity = false
    );

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertAttributeContains(
        $needle,
        $haystackAttributeName,
        $haystackClassOrObject,
        $message = '',
        $ignoreCase = false,
        $checkForObjectIdentity = true,
        $checkForNonObjectIdentity = false
    );

    /**
     * Asserts that a haystack does not contain a needle.
     *
     * @param mixed $needle
     * @param mixed $haystack
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since  Method available since Release 2.1.0
     */
    abstract public function assertNotContains(
        $needle,
        $haystack,
        $message = '',
        $ignoreCase = false,
        $checkForObjectIdentity = true,
        $checkForNonObjectIdentity = false
    );

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain a needle.
     *
     * @param mixed $needle
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     * @param bool $ignoreCase
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertAttributeNotContains(
        $needle,
        $haystackAttributeName,
        $haystackClassOrObject,
        $message = '',
        $ignoreCase = false,
        $checkForObjectIdentity = true,
        $checkForNonObjectIdentity = false
    );

    /**
     * Asserts that a haystack contains only values of a given type.
     *
     * @param string $type
     * @param mixed $haystack
     * @param bool $isNativeType
     * @param string $message
     *
     * @since  Method available since Release 3.1.4
     */
    abstract public function assertContainsOnly($type, $haystack, $isNativeType = null, $message = '');

    /**
     * Asserts that a haystack contains only instances of a given classname
     *
     * @param string $classname
     * @param array|Traversable $haystack
     * @param string $message
     */
    abstract public function assertContainsOnlyInstancesOf($classname, $haystack, $message = '');

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object contains only values of a given type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     *
     * @since  Method available since Release 3.1.4
     */
    abstract public function assertAttributeContainsOnly(
        $type,
        $haystackAttributeName,
        $haystackClassOrObject,
        $isNativeType = null,
        $message = ''
    );

    /**
     * Asserts that a haystack does not contain only values of a given type.
     *
     * @param string $type
     * @param mixed $haystack
     * @param bool $isNativeType
     * @param string $message
     *
     * @since  Method available since Release 3.1.4
     */
    abstract public function assertNotContainsOnly($type, $haystack, $isNativeType = null, $message = '');

    /**
     * Asserts that a haystack that is stored in a static attribute of a class
     * or an attribute of an object does not contain only values of a given
     * type.
     *
     * @param string $type
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param bool $isNativeType
     * @param string $message
     *
     * @since  Method available since Release 3.1.4
     */
    abstract public function assertAttributeNotContainsOnly(
        $type,
        $haystackAttributeName,
        $haystackClassOrObject,
        $isNativeType = null,
        $message = ''
    );

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     * @param mixed $haystack
     * @param string $message
     */
    abstract public function assertCount($expectedCount, $haystack, $message = '');

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.6.0
     */
    abstract public function assertAttributeCount(
        $expectedCount,
        $haystackAttributeName,
        $haystackClassOrObject,
        $message = ''
    );

    /**
     * Asserts the number of elements of an array, Countable or Traversable.
     *
     * @param int $expectedCount
     * @param mixed $haystack
     * @param string $message
     */
    abstract public function assertNotCount($expectedCount, $haystack, $message = '');

    /**
     * Asserts the number of elements of an array, Countable or Traversable
     * that is stored in an attribute.
     *
     * @param int $expectedCount
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.6.0
     */
    abstract public function assertAttributeNotCount(
        $expectedCount,
        $haystackAttributeName,
        $haystackClassOrObject,
        $message = ''
    );

    /**
     * Asserts that two variables are equal.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    abstract public function assertEquals(
        $expected,
        $actual,
        $message = '',
        $delta = 0.0,
        $maxDepth = 10,
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that a variable is equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    abstract public function assertAttributeEquals(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = '',
        $delta = 0.0,
        $maxDepth = 10,
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that two variables are not equal.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since  Method available since Release 2.3.0
     */
    abstract public function assertNotEquals(
        $expected,
        $actual,
        $message = '',
        $delta = 0.0,
        $maxDepth = 10,
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that a variable is not equal to an attribute of an object.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     */
    abstract public function assertAttributeNotEquals(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = '',
        $delta = 0.0,
        $maxDepth = 10,
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that a variable is empty.
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertEmpty($actual, $message = '');

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is empty.
     *
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeEmpty($haystackAttributeName, $haystackClassOrObject, $message = '');

    /**
     * Asserts that a variable is not empty.
     *
     * @param mixed $actual
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertNotEmpty($actual, $message = '');

    /**
     * Asserts that a static attribute of a class or an attribute of an object
     * is not empty.
     *
     * @param string $haystackAttributeName
     * @param mixed $haystackClassOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeNotEmpty($haystackAttributeName, $haystackClassOrObject, $message = '');

    /**
     * Asserts that a value is greater than another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertGreaterThan($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is greater than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertAttributeGreaterThan(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = ''
    );

    /**
     * Asserts that a value is greater than or equal to another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertGreaterThanOrEqual($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is greater than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertAttributeGreaterThanOrEqual(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = ''
    );

    /**
     * Asserts that a value is smaller than another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertLessThan($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is smaller than another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertAttributeLessThan(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = ''
    );

    /**
     * Asserts that a value is smaller than or equal to another value.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertLessThanOrEqual($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is smaller than or equal to another value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param string $actualClassOrObject
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertAttributeLessThanOrEqual(
        $expected,
        $actualAttributeName,
        $actualClassOrObject,
        $message = ''
    );

    /**
     * Asserts that the contents of one file is equal to the contents of another
     * file.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since  Method available since Release 3.2.14
     */
    abstract public function assertFileEquals(
        $expected,
        $actual,
        $message = '',
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that the contents of one file is not equal to the contents of
     * another file.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since  Method available since Release 3.2.14
     */
    abstract public function assertFileNotEquals(
        $expected,
        $actual,
        $message = '',
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that the contents of a string is equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param string $actualString
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function assertStringEqualsFile(
        $expectedFile,
        $actualString,
        $message = '',
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that the contents of a string is not equal
     * to the contents of a file.
     *
     * @param string $expectedFile
     * @param string $actualString
     * @param string $message
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function assertStringNotEqualsFile(
        $expectedFile,
        $actualString,
        $message = '',
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Asserts that a file exists.
     *
     * @param string $filename
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertFileExists($filename, $message = '');

    /**
     * Asserts that a file does not exist.
     *
     * @param string $filename
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertFileNotExists($filename, $message = '');

    /**
     * Asserts that a condition is true.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertTrue($condition, $message = '');

    /**
     * Asserts that a condition is not true.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertNotTrue($condition, $message = '');

    /**
     * Asserts that a condition is false.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertFalse($condition, $message = '');

    /**
     * Asserts that a condition is not false.
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function assertNotFalse($condition, $message = '');

    /**
     * Asserts that a variable is not null.
     *
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertNotNull($actual, $message = '');

    /**
     * Asserts that a variable is null.
     *
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertNull($actual, $message = '');

    /**
     * Asserts that a variable is finite.
     *
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertFinite($actual, $message = '');

    /**
     * Asserts that a variable is infinite.
     *
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertInfinite($actual, $message = '');

    /**
     * Asserts that a variable is nan.
     *
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertNan($actual, $message = '');

    /**
     * Asserts that a class has a specified attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertClassHasAttribute($attributeName, $className, $message = '');

    /**
     * Asserts that a class does not have a specified attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertClassNotHasAttribute($attributeName, $className, $message = '');

    /**
     * Asserts that a class has a specified static attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertClassHasStaticAttribute($attributeName, $className, $message = '');

    /**
     * Asserts that a class does not have a specified static attribute.
     *
     * @param string $attributeName
     * @param string $className
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertClassNotHasStaticAttribute($attributeName, $className, $message = '');

    /**
     * Asserts that an object has a specified attribute.
     *
     * @param string $attributeName
     * @param object $object
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertObjectHasAttribute($attributeName, $object, $message = '');

    /**
     * Asserts that an object does not have a specified attribute.
     *
     * @param string $attributeName
     * @param object $object
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertObjectNotHasAttribute($attributeName, $object, $message = '');

    /**
     * Asserts that two variables have the same type and value.
     * Used on objects, it asserts that two variables reference
     * the same object.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertSame($expected, $actual, $message = '');

    /**
     * Asserts that a variable and an attribute of an object have the same type
     * and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param object $actualClassOrObject
     * @param string $message
     */
    abstract public function assertAttributeSame($expected, $actualAttributeName, $actualClassOrObject, $message = '');

    /**
     * Asserts that two variables do not have the same type and value.
     * Used on objects, it asserts that two variables do not reference
     * the same object.
     *
     * @param mixed $expected
     * @param mixed $actual
     * @param string $message
     */
    abstract public function assertNotSame($expected, $actual, $message = '');

    /**
     * Asserts that a variable and an attribute of an object do not have the
     * same type and value.
     *
     * @param mixed $expected
     * @param string $actualAttributeName
     * @param object $actualClassOrObject
     * @param string $message
     */
    abstract public function assertAttributeNotSame($expected, $actualAttributeName, $actualClassOrObject, $message = '');

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertInstanceOf($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeInstanceOf($expected, $attributeName, $classOrObject, $message = '');

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertNotInstanceOf($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeNotInstanceOf($expected, $attributeName, $classOrObject, $message = '');

    /**
     * Asserts that a variable is of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertInternalType($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeInternalType($expected, $attributeName, $classOrObject, $message = '');

    /**
     * Asserts that a variable is not of a given type.
     *
     * @param string $expected
     * @param mixed $actual
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertNotInternalType($expected, $actual, $message = '');

    /**
     * Asserts that an attribute is of a given type.
     *
     * @param string $expected
     * @param string $attributeName
     * @param mixed $classOrObject
     * @param string $message
     *
     * @since Method available since Release 3.5.0
     */
    abstract public function assertAttributeNotInternalType($expected, $attributeName, $classOrObject, $message = '');

    /**
     * Asserts that a string matches a given regular expression.
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     */
    abstract public function assertRegExp($pattern, $string, $message = '');

    /**
     * Asserts that a string does not match a given regular expression.
     *
     * @param string $pattern
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 2.1.0
     */
    abstract public function assertNotRegExp($pattern, $string, $message = '');

    /**
     * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
     * is the same.
     *
     * @param array|Countable|Traversable $expected
     * @param array|Countable|Traversable $actual
     * @param string $message
     */
    abstract public function assertSameSize($expected, $actual, $message = '');

    /**
     * Assert that the size of two arrays (or `Countable` or `Traversable` objects)
     * is not the same.
     *
     * @param array|Countable|Traversable $expected
     * @param array|Countable|Traversable $actual
     * @param string $message
     */
    abstract public function assertNotSameSize($expected, $actual, $message = '');

    /**
     * Asserts that a string matches a given format string.
     *
     * @param string $format
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function assertStringMatchesFormat($format, $string, $message = '');

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $format
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function assertStringNotMatchesFormat($format, $string, $message = '');

    /**
     * Asserts that a string matches a given format file.
     *
     * @param string $formatFile
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function assertStringMatchesFormatFile($formatFile, $string, $message = '');

    /**
     * Asserts that a string does not match a given format string.
     *
     * @param string $formatFile
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function assertStringNotMatchesFormatFile($formatFile, $string, $message = '');

    /**
     * Asserts that a string starts with a given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function assertStringStartsWith($prefix, $string, $message = '');

    /**
     * Asserts that a string starts not with a given prefix.
     *
     * @param string $prefix
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function assertStringStartsNotWith($prefix, $string, $message = '');

    /**
     * Asserts that a string ends with a given suffix.
     *
     * @param string $suffix
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function assertStringEndsWith($suffix, $string, $message = '');

    /**
     * Asserts that a string ends not with a given suffix.
     *
     * @param string $suffix
     * @param string $string
     * @param string $message
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function assertStringEndsNotWith($suffix, $string, $message = '');

    /**
     * Asserts that two XML files are equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertXmlFileEqualsXmlFile($expectedFile, $actualFile, $message = '');

    /**
     * Asserts that two XML files are not equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertXmlFileNotEqualsXmlFile($expectedFile, $actualFile, $message = '');

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedFile
     * @param string $actualXml
     * @param string $message
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function assertXmlStringEqualsXmlFile($expectedFile, $actualXml, $message = '');

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedFile
     * @param string $actualXml
     * @param string $message
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function assertXmlStringNotEqualsXmlFile($expectedFile, $actualXml, $message = '');

    /**
     * Asserts that two XML documents are equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertXmlStringEqualsXmlString($expectedXml, $actualXml, $message = '');

    /**
     * Asserts that two XML documents are not equal.
     *
     * @param string $expectedXml
     * @param string $actualXml
     * @param string $message
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function assertXmlStringNotEqualsXmlString($expectedXml, $actualXml, $message = '');

    /**
     * Asserts that a hierarchy of DOMElements matches.
     *
     * @param DOMElement $expectedElement
     * @param DOMElement $actualElement
     * @param bool $checkAttributes
     * @param string $message
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function assertEqualXMLStructure(
        DOMElement $expectedElement,
        DOMElement $actualElement,
        $checkAttributes = false,
        $message = ''
    );

    /**
     * Evaluates a PHPUnit_Framework_Constraint matcher object.
     *
     * @param mixed $value
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $message
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function assertThat($value, PHPUnit_Framework_Constraint $constraint, $message = '');

    /**
     * Asserts that a string is a valid JSON string.
     *
     * @param string $actualJson
     * @param string $message
     *
     * @since  Method available since Release 3.7.20
     */
    abstract public function assertJson($actualJson, $message = '');

    /**
     * Asserts that two given JSON encoded objects or arrays are equal.
     *
     * @param string $expectedJson
     * @param string $actualJson
     * @param string $message
     */
    abstract public function assertJsonStringEqualsJsonString($expectedJson, $actualJson, $message = '');

    /**
     * Asserts that two given JSON encoded objects or arrays are not equal.
     *
     * @param string $expectedJson
     * @param string $actualJson
     * @param string $message
     */
    abstract public function assertJsonStringNotEqualsJsonString($expectedJson, $actualJson, $message = '');

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are equal.
     *
     * @param string $expectedFile
     * @param string $actualJson
     * @param string $message
     */
    abstract public function assertJsonStringEqualsJsonFile($expectedFile, $actualJson, $message = '');

    /**
     * Asserts that the generated JSON encoded object and the content of the given file are not equal.
     *
     * @param string $expectedFile
     * @param string $actualJson
     * @param string $message
     */
    abstract public function assertJsonStringNotEqualsJsonFile($expectedFile, $actualJson, $message = '');

    /**
     * Asserts that two JSON files are not equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     */
    abstract public function assertJsonFileNotEqualsJsonFile($expectedFile, $actualFile, $message = '');

    /**
     * Asserts that two JSON files are equal.
     *
     * @param string $expectedFile
     * @param string $actualFile
     * @param string $message
     */
    abstract public function assertJsonFileEqualsJsonFile($expectedFile, $actualFile, $message = '');

    /**
     * Returns a PHPUnit_Framework_Constraint_And matcher object.
     *
     * @return PHPUnit_Framework_Constraint_And
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function logicalAnd();

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object.
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function logicalOr();

    /**
     * Returns a PHPUnit_Framework_Constraint_Not matcher object.
     *
     * @param PHPUnit_Framework_Constraint $constraint
     *
     * @return PHPUnit_Framework_Constraint_Not
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function logicalNot(PHPUnit_Framework_Constraint $constraint);

    /**
     * Returns a PHPUnit_Framework_Constraint_Xor matcher object.
     *
     * @return PHPUnit_Framework_Constraint_Xor
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function logicalXor();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsAnything matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsAnything
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function anything();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsTrue matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsTrue
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function isTrue();

    /**
     * Returns a PHPUnit_Framework_Constraint_Callback matcher object.
     *
     * @param callable $callback
     *
     * @return PHPUnit_Framework_Constraint_Callback
     */
    abstract public function callback($callback);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsFalse matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsFalse
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function isFalse();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsJson matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsJson
     *
     * @since  Method available since Release 3.7.20
     */
    abstract public function isJson();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsNull matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsNull
     *
     * @since  Method available since Release 3.3.0
     */
    abstract public function isNull();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsFinite matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsFinite
     *
     * @since  Method available since Release 5.0.0
     */
    abstract public function isFinite();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsInfinite matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsInfinite
     *
     * @since  Method available since Release 5.0.0
     */
    abstract public function isInfinite();

    /**
     * Returns a PHPUnit_Framework_Constraint_IsNan matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsNan
     *
     * @since  Method available since Release 5.0.0
     */
    abstract public function isNan();

    /**
     * Returns a PHPUnit_Framework_Constraint_Attribute matcher object.
     *
     * @param PHPUnit_Framework_Constraint $constraint
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_Attribute
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function attribute(PHPUnit_Framework_Constraint $constraint, $attributeName);

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContains matcher
     * object.
     *
     * @param mixed $value
     * @param bool $checkForObjectIdentity
     * @param bool $checkForNonObjectIdentity
     *
     * @return PHPUnit_Framework_Constraint_TraversableContains
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function contains($value, $checkForObjectIdentity = true, $checkForNonObjectIdentity = false);

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContainsOnly matcher
     * object.
     *
     * @param string $type
     *
     * @return PHPUnit_Framework_Constraint_TraversableContainsOnly
     *
     * @since  Method available since Release 3.1.4
     */
    abstract public function containsOnly($type);

    /**
     * Returns a PHPUnit_Framework_Constraint_TraversableContainsOnly matcher
     * object.
     *
     * @param string $classname
     *
     * @return PHPUnit_Framework_Constraint_TraversableContainsOnly
     */
    abstract public function containsOnlyInstancesOf($classname);

    /**
     * Returns a PHPUnit_Framework_Constraint_ArrayHasKey matcher object.
     *
     * @param mixed $key
     *
     * @return PHPUnit_Framework_Constraint_ArrayHasKey
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function arrayHasKey($key);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEqual matcher object.
     *
     * @param mixed $value
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @return PHPUnit_Framework_Constraint_IsEqual
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function equalTo($value, $delta = 0.0, $maxDepth = 10, $canonicalize = false, $ignoreCase = false);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEqual matcher object
     * that is wrapped in a PHPUnit_Framework_Constraint_Attribute matcher
     * object.
     *
     * @param string $attributeName
     * @param mixed $value
     * @param float $delta
     * @param int $maxDepth
     * @param bool $canonicalize
     * @param bool $ignoreCase
     *
     * @return PHPUnit_Framework_Constraint_Attribute
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function attributeEqualTo(
        $attributeName,
        $value,
        $delta = 0.0,
        $maxDepth = 10,
        $canonicalize = false,
        $ignoreCase = false
    );

    /**
     * Returns a PHPUnit_Framework_Constraint_IsEmpty matcher object.
     *
     * @return PHPUnit_Framework_Constraint_IsEmpty
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function isEmpty();

    /**
     * Returns a PHPUnit_Framework_Constraint_FileExists matcher object.
     *
     * @return PHPUnit_Framework_Constraint_FileExists
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function fileExists();

    /**
     * Returns a PHPUnit_Framework_Constraint_GreaterThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_GreaterThan
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function greaterThan($value);

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object that wraps
     * a PHPUnit_Framework_Constraint_IsEqual and a
     * PHPUnit_Framework_Constraint_GreaterThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function greaterThanOrEqual($value);

    /**
     * Returns a PHPUnit_Framework_Constraint_ClassHasAttribute matcher object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ClassHasAttribute
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function classHasAttribute($attributeName);

    /**
     * Returns a PHPUnit_Framework_Constraint_ClassHasStaticAttribute matcher
     * object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ClassHasStaticAttribute
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function classHasStaticAttribute($attributeName);

    /**
     * Returns a PHPUnit_Framework_Constraint_ObjectHasAttribute matcher object.
     *
     * @param string $attributeName
     *
     * @return PHPUnit_Framework_Constraint_ObjectHasAttribute
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function objectHasAttribute($attributeName);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsIdentical matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_IsIdentical
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function identicalTo($value);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsInstanceOf matcher object.
     *
     * @param string $className
     *
     * @return PHPUnit_Framework_Constraint_IsInstanceOf
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function isInstanceOf($className);

    /**
     * Returns a PHPUnit_Framework_Constraint_IsType matcher object.
     *
     * @param string $type
     *
     * @return PHPUnit_Framework_Constraint_IsType
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function isType($type);

    /**
     * Returns a PHPUnit_Framework_Constraint_LessThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_LessThan
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function lessThan($value);

    /**
     * Returns a PHPUnit_Framework_Constraint_Or matcher object that wraps
     * a PHPUnit_Framework_Constraint_IsEqual and a
     * PHPUnit_Framework_Constraint_LessThan matcher object.
     *
     * @param mixed $value
     *
     * @return PHPUnit_Framework_Constraint_Or
     *
     * @since  Method available since Release 3.1.0
     */
    abstract public function lessThanOrEqual($value);

    /**
     * Returns a PHPUnit_Framework_Constraint_PCREMatch matcher object.
     *
     * @param string $pattern
     *
     * @return PHPUnit_Framework_Constraint_PCREMatch
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function matchesRegularExpression($pattern);

    /**
     * Returns a PHPUnit_Framework_Constraint_StringMatches matcher object.
     *
     * @param string $string
     *
     * @return PHPUnit_Framework_Constraint_StringMatches
     *
     * @since  Method available since Release 3.5.0
     */
    abstract public function matches($string);

    /**
     * Returns a PHPUnit_Framework_Constraint_StringStartsWith matcher object.
     *
     * @param mixed $prefix
     *
     * @return PHPUnit_Framework_Constraint_StringStartsWith
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function stringStartsWith($prefix);

    /**
     * Returns a PHPUnit_Framework_Constraint_StringContains matcher object.
     *
     * @param string $string
     * @param bool $case
     *
     * @return PHPUnit_Framework_Constraint_StringContains
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function stringContains($string, $case = true);

    /**
     * Returns a PHPUnit_Framework_Constraint_StringEndsWith matcher object.
     *
     * @param mixed $suffix
     *
     * @return PHPUnit_Framework_Constraint_StringEndsWith
     *
     * @since  Method available since Release 3.4.0
     */
    abstract public function stringEndsWith($suffix);

    /**
     * Returns a PHPUnit_Framework_Constraint_Count matcher object.
     *
     * @param int $count
     *
     * @return PHPUnit_Framework_Constraint_Count
     */
    abstract public function countOf($count);

    /**
     * Fails a test with the given message.
     *
     * @param string $message
     *
     * @throws PHPUnit_Framework_AssertionFailedError
     */
    abstract public function fail($message = '');

    /**
     * Returns the value of an attribute of a class or an object.
     * This also works for attributes that are declared protected or private.
     *
     * @param mixed $classOrObject
     * @param string $attributeName
     *
     * @return mixed
     *
     * @throws PHPUnit_Framework_Exception
     */
    abstract public function readAttribute($classOrObject, $attributeName);

    /**
     * Returns the value of a static attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @param string $className
     * @param string $attributeName
     *
     * @return mixed
     *
     * @throws PHPUnit_Framework_Exception
     *
     * @since  Method available since Release 4.0.0
     */
    abstract public function getStaticAttribute($className, $attributeName);

    /**
     * Returns the value of an object's attribute.
     * This also works for attributes that are declared protected or private.
     *
     * @param object $object
     * @param string $attributeName
     *
     * @return mixed
     *
     * @throws PHPUnit_Framework_Exception
     *
     * @since  Method available since Release 4.0.0
     */
    abstract public function getObjectAttribute($object, $attributeName);

    /**
     * Mark the test as incomplete.
     *
     * @param string $message
     *
     * @throws PHPUnit_Framework_IncompleteTestError
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function markTestIncomplete($message = '');

    /**
     * Mark the test as skipped.
     *
     * @param string $message
     *
     * @throws PHPUnit_Framework_SkippedTestError
     *
     * @since  Method available since Release 3.0.0
     */
    abstract public function markTestSkipped($message = '');

    /**
     * Return the current assertion count.
     *
     * @return int
     *
     * @since  Method available since Release 3.3.3
     */
    abstract public function getCount();

    /**
     * Reset the assertion counter.
     *
     * @since  Method available since Release 3.3.3
     */
    abstract public function resetCount();
}
