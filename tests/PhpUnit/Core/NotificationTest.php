<?php
/**
 * Notification.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Builder
 */

namespace Foundry\Masonry\Tests\PhpUnit\Core;

use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Tests\PhpUnit\TestCase;

/**
 * Class Notification
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 * @coversDefaultClass Foundry\Masonry\Core\Notification
 */
class NotificationTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @return void
     */
    public function testConstruct()
    {
        $message = 'message';
        $notification = new Notification($message);

        $this->assertSame(
            $message,
            $this->getObjectAttribute($notification, 'message')
        );

        $this->assertSame(
            Notification::PRIORITY_NORMAL,
            $this->getObjectAttribute($notification, 'priority')
        );

        $message = 'message';
        $priority = Notification::PRIORITY_HIGH;
        $notification = new Notification($message, $priority);

        $this->assertSame(
            $message,
            $this->getObjectAttribute($notification, 'message')
        );

        $this->assertSame(
            Notification::PRIORITY_HIGH,
            $this->getObjectAttribute($notification, 'priority')
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $priority must be an integer
     * @return void
     */
    public function testConstructInvalidPriorityType()
    {
        $message = 'message';
        $invalidPriorityType = 'Not A Number';
        new Notification($message, $invalidPriorityType);
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $priority must be greater than or equal to 0
     * @return void
     */
    public function testConstructInvalidPriority()
    {
        $message = 'message';
        $invalidPriority = -1;
        new Notification($message, $invalidPriority);
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $message must be a string
     * @return void
     */
    public function testConstructInvalidMessageType()
    {
        $message = ['message'];
        new Notification($message);
    }

    /**
     * @test
     * @covers ::getMessage
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testGetMessage()
    {
        $message1 = 'message1';
        $notification = new Notification($message1);

        $this->assertSame(
            $message1,
            $notification->getMessage()
        );

        $message2 = 'message2';
        $notification = new Notification($message2);

        $this->assertSame(
            $message2,
            $notification->getMessage()
        );
    }

    /**
     * @test
     * @covers ::getPriority
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testGetPriority()
    {
        $message = 'message';
        $notification = new Notification($message);

        $this->assertSame(
            Notification::PRIORITY_NORMAL,
            $notification->getPriority()
        );

        $priorities = [
            Notification::PRIORITY_HIGH,
            Notification::PRIORITY_NORMAL,
            Notification::PRIORITY_INFO,
            Notification::PRIORITY_DEBUG,
        ];
        foreach ($priorities as $priority) {
            $notification = new Notification($message, $priority);

            $this->assertSame(
                $priority,
                $notification->getPriority()
            );
        }

    }

    /**
     * @test
     * @covers ::__toString
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @uses Foundry\Masonry\Core\Notification::getMessage
     * @return void
     */
    public function testToString()
    {
        $message1 = 'message1';
        $notification = new Notification($message1);

        $this->assertSame(
            $message1,
            (string)$notification
        );

        $message2 = 'message2';
        $notification = new Notification($message2);

        $this->assertSame(
            $message2,
            (string)$notification
        );
    }

    /**
     * @test
     * @covers ::high
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testHigh()
    {
        $priority = Notification::PRIORITY_HIGH;
        $message1 = 'message1';
        $notification = Notification::high($message1);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message1,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );

        $message2 = 'message2';
        $notification = Notification::high($message2);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message2,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );
    }

    /**
     * @test
     * @covers ::normal
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testNormal()
    {
        $priority = Notification::PRIORITY_NORMAL;
        $message1 = 'message1';
        $notification = Notification::normal($message1);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message1,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );

        $message2 = 'message2';
        $notification = Notification::normal($message2);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message2,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );
    }

    /**
     * @test
     * @covers ::info
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testInfo()
    {
        $priority = Notification::PRIORITY_INFO;
        $message1 = 'message1';
        $notification = Notification::info($message1);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message1,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );

        $message2 = 'message2';
        $notification = Notification::info($message2);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message2,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );
    }

    /**
     * @test
     * @covers ::debug
     * @uses Foundry\Masonry\Core\Notification::__construct
     * @return void
     */
    public function testDebug()
    {
        $priority = Notification::PRIORITY_DEBUG;
        $message1 = 'message1';
        $notification = Notification::debug($message1);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message1,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );

        $message2 = 'message2';
        $notification = Notification::debug($message2);

        $this->assertInstanceOf(
            Notification::class,
            $notification
        );
        $this->assertSame(
            $message2,
            $this->getObjectAttribute($notification, 'message')
        );
        $this->assertSame(
            $priority,
            $this->getObjectAttribute($notification, 'priority')
        );
    }
}
