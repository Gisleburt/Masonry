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

/**
 * Trait HasConfigTest
 * Test for HasConfig
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Injection\HasConfig
 */
trait HasConfigTest
{

    /**
     * @return HasConfig
     */
    abstract protected function getTestSubject();

    /**
     * @test
     * @covers ::getConfig
     * @uses Foundry\Masonry\Core\Injection\HasConfig::setConfig
     * @uses \Foundry\Masonry\Core\Config::__construct
     */
    public function testGetConfig()
    {
        $testSubjectClass = $this->getTestSubjectClass();

        /** @var HasConfig $testSubject */
        $testSubject = $this->getMockBuilder($testSubjectClass)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        /** @var ConfigInterface|\PHPUnit_Framework_MockObject_MockObject $config */
        $config = $this->getMockForAbstractClass(ConfigInterface::class);
        $getConfig = $this->getObjectMethod($testSubject, 'getConfig');

        $this->assertInstanceOf(
            ConfigInterface::class,
            $getConfig()
        );

        $this->assertNotSame(
            $config,
            $getConfig()
        );

        $testSubject->setConfig($config);

        $this->assertSame(
            $config,
            $getConfig()
        );
    }

    /**
     * @test
     * @covers ::setConfig
     */
    public function testSetConfig()
    {
        $testSubjectClass = $this->getTestSubjectClass();

        /** @var HasConfig $testSubject */
        $testSubject = $this->getMockBuilder($testSubjectClass)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

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
