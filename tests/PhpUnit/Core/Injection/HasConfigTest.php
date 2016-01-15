<?php
/**
 * HasConfigTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core\Injection;

use Foundry\Masonry\Core\Injection\HasConfig;
use Foundry\Masonry\Interfaces\ConfigInterface;
use Foundry\Masonry\Tests\PhpUnit\TestCaseTrait;

/**
 * Trait HasConfigTest
 * Test for HasConfig
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait HasConfigTest
{
    use TestCaseTrait;

    /**
     * @return HasConfig
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getConfig
     * @uses Foundry\Masonry\Core\Injection\HasConfig::setConfig
     */
    public function testGetConfig()
    {
        $testSubject = $this->getTestSubject();

        /** @var ConfigInterface|\PHPUnit_Framework_MockObject_MockObject $config */
        $config = $this->getMockForAbstractClass(ConfigInterface::class);

        $initialConfig = $testSubject->getConfig();

        $this->assertInstanceOf(
            ConfigInterface::class,
            $testSubject->getConfig()
        );

        $this->assertNotSame(
            $config,
            $testSubject->getConfig()
        );

        $testSubject->setConfig($config);

        $this->assertSame(
            $config,
            $testSubject->getConfig()
        );
    }

    /**
     * @test
     * @covers ::getConfig
     */
    public function testSetConfig()
    {
        /** @var HasConfig $testSubject */
        $testSubject = $this->getTestSubject();

        /** @var ConfigInterface|\PHPUnit_Framework_MockObject_MockObject $config */
        $config = $this->getMockForAbstractClass(ConfigInterface::class);

        $this->assertNull(
            $this->getObjectAttribute($testSubject, 'config')
        );

        $this->assertSame(
            $testSubject,
            $testSubject->setConfig($config)
        );

        $this->assertSame(
            $config,
            $this->getObjectAttribute($testSubject, 'config')
        );
    }
}
