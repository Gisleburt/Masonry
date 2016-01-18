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
use Foundry\Masonry\Tests\PhpUnit\Core\Injection\HasFilesystemTest;
use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

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
    use HasFilesystemTest;

    /**
     * @return Init
     */
    protected function getTestSubject()
    {
        return new Init();
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
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     */
    public function testConfigure()
    {
        $init = new Init();

        $this->assertSame(
            'init',
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

    /**
     * @test
     * @covers ::execute
     * @uses \Foundry\Masonry\Console\Command\Init::configure
     * @uses \Foundry\Masonry\Console\Command\Init::createConfigurationArray
     * @uses \Foundry\Masonry\Console\Command\Init::toYaml
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait
     * @uses \Foundry\Masonry\Core\Config
     * @uses \Foundry\Masonry\Core\Injection\HasConfig
     * @uses \Foundry\Masonry\Core\Injection\HasFilesystem
     */
    public function testExecute()
    {
        /** @var Filesystem|\PHPUnit_Framework_MockObject_MockObject $fs */
        $fs = $this->getMock(Filesystem::class);
        $fs
            ->expects($this->once())
            ->method('exists')
            ->with('masonry.yaml')
            ->will($this->returnValue(false));
        $fs
            ->expects($this->once())
            ->method('dumpFile');

        $init = new Init();
        $init->setFilesystem($fs);

        $execute = $this->getObjectMethod($init, 'execute');


        $input = $this->getMockForAbstractClass(InputInterface::class);
        $output = $this->getMockForAbstractClass(OutputInterface::class);
        $output
            ->expects($this->atLeastOnce())
            ->method('writeln')
            ->with($this->logicalNot($this->isEmpty()))
            ->will($this->returnValue(null));

        $execute($input, $output);
    }

    /**
     * @test
     * @covers ::createConfigurationArray
     * @uses \Foundry\Masonry\Console\Command\Init::configure
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     * @uses \Foundry\Masonry\Core\Injection\HasConfig::getConfig
     * @uses \Foundry\Masonry\Core\Config
     */
    public function testCreateConfigurationArray()
    {
        $input = $this->getMockForAbstractClass(InputInterface::class);

        $init = new Init();
        $createConfigurationArray = $this->getObjectMethod($init, 'createConfigurationArray');

        $this->assertArrayHasKey(
            'pool',
            $createConfigurationArray($input)
        );

        $this->assertArrayHasKey(
            'workerModules',
            $createConfigurationArray($input)
        );
    }

    /**
     * @test
     * @covers ::toYaml
     * @uses \Foundry\Masonry\Console\Command\Init::configure
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     */
    public function testToYaml()
    {
        $init = new Init();
        $toYaml = $this->getObjectMethod($init, 'toYaml');

        $testData = [
            'bool' => true,
            'object' => [
                'string' => 'hello',
                'integer' => 42,
            ],
        ];

        $expectedData =
            "bool: true\n" .
            "object:\n" .
            "    string: hello\n" .
            "    integer: 42\n";

        $this->assertSame(
            $expectedData,
            $toYaml($testData)
        );
    }

}
