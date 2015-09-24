<?php
/**
 * Result.php
 * PHP version 5.4
 * 2015-09-24
 *
 * @package   Foundry\Masonry
 * @category  Tests
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Tests\PhpUnit\Core\Task\History;

use Foundry\Masonry\Tests\PhpUnit\TestCase;
use Foundry\Masonry\Core\Task\History\Result;

/**
 * Class Result
 *
 * @package Foundry\Masonry
 * @coversDefaultClass \Foundry\Masonry\Core\Task\History\Result
 */
class ResultTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Result::getResult
     * @return void
     */
    public function testConstruct()
    {
        $result = new Result(Result::RESULT_SUCCEEDED);

        $this->assertNotEmpty(
            $result->getResult()
        );

        $this->assertSame(
            Result::RESULT_SUCCEEDED,
            $result->getResult()
        );

        $result = new Result();

        $this->assertNotEmpty(
            $result->getResult()
        );

        $this->assertSame(
            Result::RESULT_INCOMPLETE,
            $result->getResult()
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @expectedException \Foundry\Masonry\Core\Exception\InvalidResult
     * @return void
     */
    public function testConstructException()
    {
        $result = new Result('not a valid Result');
    }

    /**
     * @test
     * @covers ::getResult
     * @uses \Foundry\Masonry\Core\Task\History\Result::__construct
     * @return void
     */
    public function testGetResult()
    {
        $result = new Result(Result::RESULT_SUCCEEDED);

        $this->assertNotEmpty(
            $result->getResult()
        );

        $this->assertSame(
            Result::RESULT_SUCCEEDED,
            $result->getResult()
        );
    }

    /**
     * @test
     * @covers ::__toString
     * @uses \Foundry\Masonry\Core\Task\History\Result::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Result::getResult
     * @return void
     */
    public function testToString()
    {
        $result = new Result(Result::RESULT_SUCCEEDED);

        $this->assertNotEmpty(
            $result->getResult()
        );

        $this->assertSame(
            Result::RESULT_SUCCEEDED,
            $result->__toString()
        );

        $this->assertSame(
            Result::RESULT_SUCCEEDED,
            (string)$result
        );
    }

    /**
     * @test
     * @covers ::isSuccess
     * @uses \Foundry\Masonry\Core\Task\History\Result::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Result::getResult
     * @return void
     */
    public function testIsSuccess()
    {
        $result = new Result();
        $this->assertFalse(
            $result->isSuccess()
        );

        $result = new Result(Result::RESULT_SUCCEEDED);
        $this->assertTrue(
            $result->isSuccess()
        );

        $result = new Result(Result::RESULT_FAILED);
        $this->assertFalse(
            $result->isSuccess()
        );

        $result = new Result(Result::RESULT_INCOMPLETE);
        $this->assertFalse(
            $result->isSuccess()
        );
    }

    /**
     * @test
     * @covers ::isFailure
     * @uses \Foundry\Masonry\Core\Task\History\Result::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Result::getResult
     * @return void
     */
    public function testIsFailure()
    {
        $result = new Result();
        $this->assertFalse(
            $result->isFailure()
        );

        $result = new Result(Result::RESULT_SUCCEEDED);
        $this->assertFalse(
            $result->isFailure()
        );

        $result = new Result(Result::RESULT_FAILED);
        $this->assertTrue(
            $result->isFailure()
        );

        $result = new Result(Result::RESULT_INCOMPLETE);
        $this->assertFalse(
            $result->isFailure()
        );
    }

    /**
     * @test
     * @covers ::isComplete
     * @uses \Foundry\Masonry\Core\Task\History\Result::__construct
     * @uses \Foundry\Masonry\Core\Task\History\Result::getResult
     * @uses \Foundry\Masonry\Core\Task\History\Result::isFailure
     * @uses \Foundry\Masonry\Core\Task\History\Result::isSuccess
     * @return void
     */
    public function testIsComplete()
    {
        $result = new Result();
        $this->assertFalse(
            $result->isComplete()
        );

        $result = new Result(Result::RESULT_SUCCEEDED);
        $this->assertTrue(
            $result->isComplete()
        );

        $result = new Result(Result::RESULT_FAILED);
        $this->assertTrue(
            $result->isComplete()
        );

        $result = new Result(Result::RESULT_INCOMPLETE);
        $this->assertFalse(
            $result->isComplete()
        );
    }
}
