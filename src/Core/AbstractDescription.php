<?php
/**
 * AbstractDescription.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\Task\DescriptionInterface;


/**
 * Class AbstractDescription
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractDescription implements DescriptionInterface
{

    /**
     * Create a description a keyed array of parameters
     * @param array $parameters
     * @return static
     */
    public static function createFromParameters(array $parameters = [])
    {
        $parameters = static::flattenKeys($parameters);

        $reflectionClass = new \ReflectionClass(static::class);
        $constructor = $reflectionClass->getConstructor();
        $reflectionParameters = $constructor->getParameters();

        $constructorArguments = [];
        foreach ($reflectionParameters as $reflectionParameter) {
            $name = static::flatten($reflectionParameter->getName());
            if (isset($parameters[$name])) {
                $constructorArguments[] = $parameters[$name];
                continue;
            }
            if ($reflectionParameter->isDefaultValueAvailable()) {
                $constructorArguments[] = $reflectionParameter->getDefaultValue();
                continue;
            }
            $constructorArguments[] = null;
        }
        return $reflectionClass->newInstanceArgs($constructorArguments);
    }

    /**
     * Takes an array, returns a copy with the keys flattened.
     * @param array $array
     * @return array
     */
    private static function flattenKeys(array $array)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[static::flatten($key)] = $value;
        }
        return $newArray;
    }

    /**
     * Flattens a string.
     * Removes non-word characters and underscores, and changes to lower case. Useful for loose comparison.
     * @param $string
     * @return string
     */
    private static function flatten($string)
    {
        return strtolower(preg_replace('/[\W_]/', '', $string));
    }

}
