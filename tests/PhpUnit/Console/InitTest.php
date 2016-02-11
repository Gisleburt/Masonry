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
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Logging\MultiLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class InitTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Init
 */
class InitTest extends AbstractCommandTest
{
    /**
     * @var LoggerInterface
     */
    private $oldLogger;

    /**
     * Some tests change states so record them before the test here.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oldLogger = $this->getStaticAttribute(GlobalRegister::class, 'logger');
    }

    /**
     * Put the system back into it's old state.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->setStaticAttribute(GlobalRegister::class, 'logger', $this->oldLogger);
    }

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

    /**
     * @test
     * @covers ::execute
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Core\GlobalRegister
     */
    public function testExecute()
    {
        $testFileName = 'test-file-name';
        $input  = $this->getMockForAbstractClass(InputInterface::class);
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = $this->getMock(MultiLogger::class);
        $logger
            ->expects($this->at(0))
            ->method('info')
            ->with($this->stringContains("Creating"));
        $logger
            ->expects($this->at(1))
            ->method('info')
            ->with("Done");

        $fileSystem = $this->getMock(Filesystem::class);
        $fileSystem
            ->expects($this->once())
            ->method('exists')
            ->with($testFileName)
            ->will($this->returnValue(false));
        $fileSystem
            ->expects($this->once())
            ->method('dumpFile')
            ->with($testFileName, '');

        $init =
            $this
                ->getMockBuilder(Init::class)
                ->disableOriginalConstructor()
                ->setMethods(['setUpLogger', 'getFilesystem', 'getQueueFullPath',])
                ->getMock();
        $init
            ->expects($this->once())
            ->method('setUpLogger')
            ->with($output)
            ->will($this->returnValue($logger));
        $init
            ->expects($this->once())
            ->method('getFilesystem')
            ->with()
            ->will($this->returnValue($fileSystem));
        $init
            ->expects($this->once())
            ->method('getQueueFullPath')
            ->with($input)
            ->will($this->returnValue($testFileName));

        $execute = $this->getObjectMethod($init, 'execute');

        $execute($input, $output);
    }

    /**
     * @test
     * @covers ::execute
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Core\GlobalRegister
     * @expectedException \Foundry\Masonry\Console\Exception\FileExistsException
     * @expectedExceptionMessage File 'test-file-name' already exists
     */
    public function testExecuteException()
    {
        $testFileName = 'test-file-name';
        $input  = $this->getMockForAbstractClass(InputInterface::class);
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = $this->getMock(MultiLogger::class);
        $logger
            ->expects($this->never())
            ->method('info');

        $fileSystem = $this->getMock(Filesystem::class);
        $fileSystem
            ->expects($this->once())
            ->method('exists')
            ->with($testFileName)
            ->will($this->returnValue(true));
        $fileSystem
            ->expects($this->never())
            ->method('dumpFile');

        $init =
            $this
                ->getMockBuilder(Init::class)
                ->disableOriginalConstructor()
                ->setMethods(['setUpLogger', 'getFilesystem', 'getQueueFullPath',])
                ->getMock();
        $init
            ->expects($this->once())
            ->method('setUpLogger')
            ->with($output)
            ->will($this->returnValue($logger));
        $init
            ->expects($this->once())
            ->method('getFilesystem')
            ->with()
            ->will($this->returnValue($fileSystem));
        $init
            ->expects($this->once())
            ->method('getQueueFullPath')
            ->with($input)
            ->will($this->returnValue($testFileName));

        $execute = $this->getObjectMethod($init, 'execute');

        $execute($input, $output);
    }
}
