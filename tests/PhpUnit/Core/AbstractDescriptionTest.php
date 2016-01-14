<?php
/**
 * AbstractDescriptionTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\AbstractDescription;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class AbstractDescriptionTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractDescription
 */
abstract class AbstractDescriptionTest extends TestCase
{

    /**
     * This method needs to be overwritten for all descriptions
     * @return void
     */
    abstract public function testCreateFromParameters();

    /**
     * @test
     * @covers ::flatten
     */
    public function testFlatten()
    {
        $method = new \ReflectionMethod(AbstractDescription::class, 'flatten');
        $method->setAccessible(true);

        $before = 'aB_3-4';
        $after = 'ab34';

        $this->assertSame(
            $after,
            $method->invoke(null, $before)
        );
    }

    public function testFlattenKeys()
    {
        $method = new \ReflectionMethod(AbstractDescription::class, 'flattenKeys');
        $method->setAccessible(true);

        $before = [
            'key1' => 'value1',
            'aB34' => 'value2',
            'key3' => 'value3',
            'aB_3-4' => 'value4',
        ];
        $after = [
            'key1' => 'value1',
            'ab34' => 'value4',
            'key3' => 'value3',
        ];

        $this->assertSame(
            $after,
            $method->invoke(null, $before)
        );
    }
}
