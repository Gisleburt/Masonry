<?php
/**
 * HasFilesystemTest.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core\Injection;

use Foundry\Masonry\Core\Injection\HasFilesystem;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Trait HasFilesystemTest
 * Test for HasFilesystem
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Injection\HasFilesystem
 */
trait HasFilesystemTest
{

    /**
     * @return string
     */
    abstract protected function getTestSubjectClass();

    /**
     * @test
     * @covers ::getFilesystem
     * @uses \Foundry\Masonry\Core\Injection\HasFilesystem::setFilesystem
     */
    public function testGetFilesystem()
    {
        $testSubjectClass = $this->getTestSubjectClass();

        /** @var HasFilesystem $testSubject */
        $testSubject = $this->getMockBuilder($testSubjectClass)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        /** @var Filesystem|\PHPUnit_Framework_MockObject_MockObject $filesystem */
        $filesystem = $this->getMock(Filesystem::class);

        $getFilesystem = $this->getObjectMethod($testSubject, 'getFilesystem');

        $this->assertInstanceOf(
            Filesystem::class,
            $getFilesystem()
        );

        $this->assertNotSame(
            $filesystem,
            $getFilesystem()
        );

        $testSubject->setFilesystem($filesystem);

        $this->assertSame(
            $filesystem,
            $getFilesystem()
        );
    }

    /**
     * @test
     * @covers ::setFilesystem
     */
    public function testSetFilesystem()
    {
        $testSubjectClass = $this->getTestSubjectClass();

        /** @var HasFilesystem $testSubject */
        $testSubject = $this->getMockBuilder($testSubjectClass)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        /** @var Filesystem|\PHPUnit_Framework_MockObject_MockObject $filesystem */
        $filesystem = $this->getMock(Filesystem::class);

        $this->assertNull(
            $this->getObjectAttribute($testSubject, 'filesystem')
        );

        $this->assertSame(
            $testSubject,
            $testSubject->setFilesystem($filesystem)
        );

        $this->assertSame(
            $filesystem,
            $this->getObjectAttribute($testSubject, 'filesystem')
        );
    }
}
