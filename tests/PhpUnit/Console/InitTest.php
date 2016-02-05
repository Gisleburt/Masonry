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
use Symfony\Component\Console\Input\InputArgument;

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

    /**
     * @test
     * @covers ::configure
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     */
    public function testConfigure()
    {
        $command = new Init();

        $this->assertSame(
            'init',
            $command->getName()
        );
        $this->assertSame(
            'Initialise Masonry in the current directory with a masonry.yaml',
            $command->getDescription()
        );
    }
}
