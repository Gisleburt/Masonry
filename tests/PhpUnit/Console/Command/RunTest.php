<?php
/**
 * RunTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console\Command;

use Foundry\Masonry\Console\Command\Run;
use Foundry\Masonry\Tests\PhpUnit\Console\Command\Shared\ConfigTraitTest;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class RunTest
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Run
 */
class RunTest extends TestCase
{

    use ConfigTraitTest;

    /**
     * @return Run
     */
    protected function getTestSubject()
    {
        return new Run();
    }
}
