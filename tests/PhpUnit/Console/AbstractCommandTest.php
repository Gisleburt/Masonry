<?php
/**
 * AbstractCommandTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console;

use Foundry\Masonry\Console\Command\AbstractCommand;
use Foundry\Masonry\Logging\MultiLogger;
use Foundry\Masonry\Tests\PhpUnit\Core\Injection\HasFilesystemTest;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommandTest
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractCommandTest extends TestCase
{
    use HasFilesystemTest;

    /**
     * @test
     * @covers ::abstractConfigure
     * @uses \Foundry\Masonry\Console\Command\Init
     * @uses \Foundry\Masonry\Console\Command\Run
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     */
    public function testAbstractConfigure()
    {
        $commandClass = $this->getTestSubjectClass();
        /** @var AbstractCommand $command */
        $command = new $commandClass();

        $this->assertNotNull(
            $command->getName()
        );
        $this->assertNotNull(
            $command->getDescription()
        );
        $this->assertInstanceOf(
            InputArgument::class,
            $command->getNativeDefinition()->getArgument('queue')
        );
    }

    /**
     * @test
     * @covers ::setUpLogger
     * @uses \Foundry\Masonry\Console\Command\Init
     * @uses \Foundry\Masonry\Console\Command\Run
     * @uses \Foundry\Masonry\Logging\SymfonyOutputLogger
     * @uses \Foundry\Masonry\Logging\MultiLogger
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     */
    public function testSetUpLogger()
    {
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $commandClass = $this->getTestSubjectClass();
        /** @var AbstractCommand $command */
        $command = new $commandClass();

        $setUpLogger = $this->getObjectMethod($command, 'setUpLogger');

        $this->assertInstanceOf(
            MultiLogger::class,
            $setUpLogger($output)
        );
    }

    /**
     * @test
     * @covers ::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\Init
     * @uses \Foundry\Masonry\Console\Command\Run
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     */
    public function testGetQueueArgument()
    {
        $commandClass = $this->getTestSubjectClass();
        /** @var AbstractCommand $command */
        $command = new $commandClass();

        $getQueueArgument = $this->getObjectMethod($command, 'getQueueArgument');
        /** @var InputArgument $queueArgument */
        $queueArgument = $getQueueArgument();

        $this->assertInstanceOf(
            InputArgument::class,
            $queueArgument
        );
        $this->assertSame(
            'queue',
            $queueArgument->getName()
        );
        $this->assertFalse(
            $queueArgument->isRequired()
        );
        $this->assertSame(
            'The name of the initial queue to use',
            $queueArgument->getDescription()
        );
        $this->assertSame(
            'queue.yaml',
            $queueArgument->getDefault()
        );
    }

    /**
     * @test
     * @covers ::getQueueFullPath
     * @uses \Foundry\Masonry\Console\Command\Init
     * @uses \Foundry\Masonry\Console\Command\Run
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     */
    public function testGetQueueFullPath()
    {
        $defaultPath = 'queue.yaml';
        $testPath = 'testPath';

        $commandClass = $this->getTestSubjectClass();
        /** @var AbstractCommand $command */
        $command = new $commandClass();

        $getQueueFullPath = $this->getObjectMethod($command, 'getQueueFullPath');


        $input = $this->getMockForAbstractClass(InputInterface::class);
        $input
            ->expects($this->exactly(2))
            ->method('hasArgument')
            ->with('queue')
            ->will($this->onConsecutiveCalls(false, true));
        $input
            ->expects($this->once())
            ->method('getArgument')
            ->with('queue')
            ->will($this->returnValue($testPath));

        $this->assertSame(
            $defaultPath,
            $getQueueFullPath($input)
        );
        $this->assertSame(
            $testPath,
            $getQueueFullPath($input)
        );
    }

    /**
     * @test
     * @covers ::getCwd
     * @uses \Foundry\Masonry\Console\Command\Init
     * @uses \Foundry\Masonry\Console\Command\Run
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     */
    public function testGetCwd()
    {
        $commandClass = $this->getTestSubjectClass();
        /** @var AbstractCommand $command */
        $command = new $commandClass();
        $getCwd = $this->getObjectMethod($command, 'getCwd');
        $this->assertSame(
            getcwd(),
            $getCwd()
        );
    }
}
