<?php
/**
 * DescriptionTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group\Serial;

use Foundry\Masonry\Tests\PhpUnit\Workers\Group\AbstractGroupDescriptionTest;
use Foundry\Masonry\Workers\Group\Serial\Description;

/**
 * Class DescriptionTest
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\Serial\Description
 */
class DescriptionTest extends AbstractGroupDescriptionTest
{
    /**
     * @return string
     */
    protected function getClassName()
    {
        return Description::class;
    }
}
