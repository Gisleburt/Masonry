<?php
/**
 * ConfigTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Console\Command\Shared;

use Foundry\Masonry\Tests\PhpUnit\Core\Injection\HasConfigTest;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Trait ConfigTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Console\Command\Shared\ConfigTrait
 */
trait ConfigTraitTest
{
    use HasConfigTest;

    /**
     * @test
     * @covers ::getConfigArgument
     *
     * Every test class:
     *
     * @uses Foundry\Masonry\Console\Command\Init::configure
     * @uses Foundry\Masonry\Console\Command\Run::configure
     */
    public function testGetConfigArgument()
    {
        $testSubject = $this->getTestSubject();
        $getConfigArgument = $this->getObjectMethod($testSubject, 'getConfigArgument');

        /** @var InputArgument $configArgument */
        $configArgument = $getConfigArgument();
        $this->assertInstanceOf(
            InputArgument::class,
            $configArgument
        );

        $this->assertSame(
            'config',
            $configArgument->getName()
        );

        $this->assertSame(
            'masonry.yaml',
            $configArgument->getDefault()
        );

        $this->assertNotNull(
            $configArgument->getDescription()
        );
    }

    /**
     * @test
     * @covers ::getConfigFileFullPath
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     *
     * Every test class:
     *
     * @uses Foundry\Masonry\Console\Command\Init::configure
     * @uses Foundry\Masonry\Console\Command\Run::configure
     */
    public function testGetConfigFileFullPathDefault()
    {
        $testSubject = $this->getTestSubject();
        $getConfigFileFullPath = $this->getObjectMethod($testSubject, 'getConfigFileFullPath');

        $this->assertSame(
            'masonry.yaml',
            $getConfigFileFullPath()
        );
    }

    /**
     * @test
     * @covers ::getConfigFileFullPath
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     *
     * Every test class:
     *
     * @uses Foundry\Masonry\Console\Command\Init::configure
     * @uses Foundry\Masonry\Console\Command\Run::configure
     */
    public function testGetConfigFileFullPathInput()
    {
        $testValue = 'test value';

        $input = $this->getMockForAbstractClass(InputInterface::class);
        $input
            ->expects($this->once())
            ->method('hasArgument')
            ->with('config')
            ->will($this->returnValue(true));
        $input
            ->expects($this->once())
            ->method('getArgument')
            ->with('config')
            ->will($this->returnValue($testValue));
        $testSubject = $this->getTestSubject();
        $getConfigFileFullPath = $this->getObjectMethod($testSubject, 'getConfigFileFullPath');

        $this->assertSame(
            $testValue,
            $getConfigFileFullPath($input)
        );
    }

    /**
     * @test
     * @covers ::getCwd
     * @uses \Foundry\Masonry\Console\Command\Shared\ConfigTrait::getConfigArgument
     *
     * Every test class:
     *
     * @uses Foundry\Masonry\Console\Command\Init::configure
     * @uses Foundry\Masonry\Console\Command\Run::configure
     */
    public function testGetCwd()
    {
        $testSubject = $this->getTestSubject();
        $getCwd = $this->getObjectMethod($testSubject, 'getCwd');

        $this->assertSame(
            getcwd(),
            $getCwd()
        );
    }
}
