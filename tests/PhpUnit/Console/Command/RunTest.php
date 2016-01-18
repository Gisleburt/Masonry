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
use Foundry\Masonry\Tests\PhpUnit\Core\Injection\HasFilesystemTest;
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
    use HasFilesystemTest;

    /**
     * @return Run
     */
    protected function getTestSubject()
    {
        return new Run();
    }

    /**
     * @return string
     */
    protected function getTestSubjectClass()
    {
        return Run::class;
    }

    /**
     * @test
     * @covers ::configure
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     */
    public function testConfigure()
    {
        $init = new Run();

        $this->assertSame(
            'run',
            $init->getName()
        );

        $this->assertNotEmpty(
            $init->getDescription()
        );

        $this->assertNotEmpty(
            $init->getNativeDefinition()->getArguments()
        );

        $this->assertNotNull(
            $init->getNativeDefinition()->getArgument('config')
        );
    }
}
