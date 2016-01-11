<?php
/**
 * DescriptionTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Tests\PhpUnit\Workers\Group\Parallel;

use Foundry\Masonry\Tests\PhpUnit\Workers\Group\AbstractGroupDescriptionTest;
use Foundry\Masonry\Workers\Group\Parallel\Description;

/**
 * Class DescriptionTest
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Workers\Group\Parallel\Description
 */
class DescriptionTest extends AbstractGroupDescriptionTest
{
    /**
     * @return string
     */
    protected function getGroupDescriptionClass()
    {
        return Description::class;
    }
}
