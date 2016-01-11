<?php
/**
 * AbstractDescriptionTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Tests\PhpUnit\TestCase;


/**
 * Class AbstractDescriptionTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\AbstractDescription
 */
abstract class AbstractDescriptionTest extends TestCase
{

    abstract public function testCreateFromParameters();

}
