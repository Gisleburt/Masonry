<?php
/**
 * InitTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console;

use Foundry\Masonry\Console\Command\Init;

/**
 * Class InitTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Init
 */
class InitTest extends AbstractCommandTest
{
    /**
     * @return string
     */
    protected function getTestSubjectClass()
    {
        return Init::class;
    }
}
