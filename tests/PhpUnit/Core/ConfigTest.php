<?php
/**
 * ConfigTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license   MIT
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Config;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Class ConfigTest
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Config
 */
class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers ::__construct
     */
    public function testConstruct()
    {
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $module1 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $module2 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $modules = [
            $module1,
            $module2
        ];

        $config = new Config($pool, $modules);

        $this->assertSame(
            $pool,
            $this->getObjectAttribute($config, 'pool')
        );
        $this->assertSame(
            $modules,
            $this->getObjectAttribute($config, 'workerModules')
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /All worker modules must implement \w+/
     */
    public function testConstructException()
    {
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $module1 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $module2 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $modules = [
            $module1,
            $module2,
            $pool,
        ];

        new Config($pool, $modules);
    }

    /**
     * @test
     * @covers ::getPool
     * @uses \Foundry\Masonry\Core\Config::__construct
     */
    public function testGetPool()
    {
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $modules = [];

        $config = new Config($pool, $modules);

        $this->assertSame(
            $pool,
            $config->getPool()
        );
    }

    /**
     * @test
     * @covers ::getWorkerModules
     * @uses \Foundry\Masonry\Core\Config::__construct
     */
    public function testGetWorkerModules()
    {
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $module1 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $module2 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $modules = [
            $module1,
            $module2
        ];

        $config = new Config($pool, $modules);

        $this->assertSame(
            $modules,
            $config->getWorkerModules()
        );
    }

    /**
     * @test
     * @covers ::toArray
     * @uses \Foundry\Masonry\Core\Config::__construct
     * @uses \Foundry\Masonry\Core\Config::getPool
     * @uses \Foundry\Masonry\Core\Config::getWorkerModules
     */
    public function testToArray()
    {
        /** @var PoolInterface|\PHPUnit_Framework_MockObject_MockObject $pool */
        $pool = $this->getMockForAbstractClass(PoolInterface::class);
        $module1 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $module2 = $this->getMockForAbstractClass(WorkerModuleInterface::class);
        $modules = [
            $module1,
            $module2
        ];

        $config = new Config($pool, $modules);

        $this->assertSame(
            $pool,
            $config->toArray()['pool']
        );
        $this->assertSame(
            $modules,
            $config->toArray()['workerModules']
        );
    }
}
