<?php
/**
 * InitTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console\Command;

use Foundry\Masonry\Console\Command\Init;
use Foundry\Masonry\Tests\PhpUnit\Console\Command\Shared\ConfigTraitTest;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class InitTest
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Init
 */
class InitTest extends TestCase
{

    use ConfigTraitTest;

    /**
     * @return Init
     */
    protected function getTestSubject()
    {
        return new Init();
    }
}
