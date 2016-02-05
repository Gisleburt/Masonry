<?php
/**
 * RunTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console;

use Foundry\Masonry\Console\Command\Run;

/**
 * Class RunTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Run
 */
class RunTest extends AbstractCommandTest
{
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
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     */
    public function testConfigure()
    {
        $command = new Run();

        $this->assertSame(
            'run',
            $command->getName()
        );
        $this->assertSame(
            'Runs the currently configured masonry config.',
            $command->getDescription()
        );
    }
}
