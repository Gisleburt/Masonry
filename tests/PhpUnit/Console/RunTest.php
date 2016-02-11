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
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Logging\MultiLogger;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class RunTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Run
 */
class RunTest extends AbstractCommandTest
{
    /**
     * @var LoggerInterface
     */
    private $oldLogger;

    /**
     * @var LoggerInterface
     */
    private $oldModuleRegister;

    /**
     * @var LoggerInterface
     */
    private $oldMediator;

    /**
     * Some tests change states so record them before the test here.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->oldLogger = $this->getStaticAttribute(GlobalRegister::class, 'logger');
        $this->oldModuleRegister = $this->getStaticAttribute(GlobalRegister::class, 'moduleRegister');
        $this->oldMediator = $this->getStaticAttribute(GlobalRegister::class, 'mediator');
    }

    /**
     * Put the system back into it's old state.
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->setStaticAttribute(GlobalRegister::class, 'logger', $this->oldLogger);
        $this->setStaticAttribute(GlobalRegister::class, 'moduleRegister', $this->oldModuleRegister);
        $this->setStaticAttribute(GlobalRegister::class, 'mediator', $this->oldMediator);
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

    /**
     * @test
     * @covers ::execute
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Core\AbstractStatus
     * @uses \Foundry\Masonry\Core\AbstractWorker
     * @uses \Foundry\Masonry\Core\ArrayPool
     * @uses \Foundry\Masonry\Core\Coroutine
     * @uses \Foundry\Masonry\Core\CoroutineRegister
     * @uses \Foundry\Masonry\Core\GlobalRegister
     * @uses \Foundry\Masonry\Core\Mediator
     * @uses \Foundry\Masonry\Core\Notification
     * @uses \Foundry\Masonry\Core\Pool
     * @uses \Foundry\Masonry\Core\Pool\Status
     * @uses \Foundry\Masonry\Core\Task
     * @uses \Foundry\Masonry\Workers\Group\Serial\Worker
     * @uses \Foundry\Masonry\Workers\Group\Parallel\Worker::getDescriptionTypes
     * @uses \Foundry\Masonry\Workers\Group\AbstractGroupDescription
     */
    public function testExecute()
    {
        $testFileName = 'test-file-name';
        $input = $this->getMockForAbstractClass(InputInterface::class);
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = $this->getMock(MultiLogger::class);
        $logger
            ->expects($this->at(0))
            ->method('info')
            ->with('Setting up module register');
        $logger
            ->expects($this->at(1))
            ->method('info')
            ->with('Loading queue');
        $logger
            ->expects($this->at(2))
            ->method('info')
            ->with('Processing queue');

        $logger
            ->expects($this->at(3))
            ->method('info')
            ->with('Done');

        $fileSystem = $this->getMock(Filesystem::class);
        $fileSystem
            ->expects($this->once())
            ->method('exists')
            ->with($testFileName)
            ->will($this->returnValue(true));

        $run =
            $this
                ->getMockBuilder(Run::class)
                ->disableOriginalConstructor()
                ->setMethods(['setUpLogger', 'getFilesystem', 'getQueueFullPath', 'readYamlFile'])
                ->getMock();
        $run
            ->expects($this->once())
            ->method('setUpLogger')
            ->with($output)
            ->will($this->returnValue($logger));
        $run
            ->expects($this->once())
            ->method('getFilesystem')
            ->with()
            ->will($this->returnValue($fileSystem));
        $run
            ->expects($this->once())
            ->method('getQueueFullPath')
            ->with($input)
            ->will($this->returnValue($testFileName));
        $run
            ->expects($this->once())
            ->method('readYamlFile')
            ->with($testFileName)
            ->will($this->returnValue([]));

        $execute = $this->getObjectMethod($run, 'execute');

        $execute($input, $output);
    }

    /**
     * @test
     * @covers ::execute
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::getQueueArgument
     * @uses \Foundry\Masonry\Console\Command\AbstractCommand::abstractConfigure
     * @uses \Foundry\Masonry\Core\GlobalRegister
     * @expectedException \Foundry\Masonry\Console\Exception\FileExistsException
     * @expectedExceptionMessage File 'test-file-name' doesn't exist, run 'masonry init' to create one
     */
    public function testExecuteException()
    {
        $testFileName = 'test-file-name';
        $input = $this->getMockForAbstractClass(InputInterface::class);
        $output = $this->getMockForAbstractClass(OutputInterface::class);

        $logger = $this->getMock(MultiLogger::class);
        $logger
            ->expects($this->at(0))
            ->method('info')
            ->with('Setting up module register');
        $logger
            ->expects($this->at(1))
            ->method('info')
            ->with('Loading queue');

        $fileSystem = $this->getMock(Filesystem::class);
        $fileSystem
            ->expects($this->once())
            ->method('exists')
            ->with($testFileName)
            ->will($this->returnValue(false));

        $run =
            $this
                ->getMockBuilder(Run::class)
                ->disableOriginalConstructor()
                ->setMethods(['setUpLogger', 'getFilesystem', 'getQueueFullPath',])
                ->getMock();
        $run
            ->expects($this->once())
            ->method('setUpLogger')
            ->with($output)
            ->will($this->returnValue($logger));
        $run
            ->expects($this->once())
            ->method('getFilesystem')
            ->with()
            ->will($this->returnValue($fileSystem));
        $run
            ->expects($this->once())
            ->method('getQueueFullPath')
            ->with($input)
            ->will($this->returnValue($testFileName));

        $execute = $this->getObjectMethod($run, 'execute');

        $execute($input, $output);
    }
}
