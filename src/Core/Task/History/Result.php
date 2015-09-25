<?php
/**
 * Result.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core\Task\History;

use Foundry\Masonry\Core\Exception\InvalidResult;
use Foundry\Masonry\Interfaces\Task\History\ResultInterface;

/**
 * Class Result
 * The result of the task. Can be 'succeeded', 'failed' or 'incomplete'.
 * @package Foundry\Masonry
 */
class Result implements ResultInterface
{

    /**
     * @var string
     */
    private $result;

    /**
     * Result constructor.
     * Should be instantiate with 'succeeded' of 'failed', otherwise it will be 'incomplete'
     * @param $result
     * @throws InvalidResult
     */
    public function __construct($result = null)
    {
        if(!$result) {
            $result = static::RESULT_INCOMPLETE;
        }
        $acceptableResults = [
            static::RESULT_SUCCEEDED,
            static::RESULT_FAILED,
            static::RESULT_INCOMPLETE,
        ];
        if (!in_array($result, $acceptableResults)) {
            throw new InvalidResult(
                "Received result '$result'; only the following are acceptable: ".implode(', ', $acceptableResults)
            );
        }
        $this->result = $result;
    }

    /**
     * Will be Succeeded, Failed or Incomplete
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * For comparing to strings
     * @return mixed
     */
    public function __toString()
    {
        return $this->getResult();
    }

    /**
     * Did the task succeed
     * @return bool
     */
    public function isSuccess()
    {
        return static::RESULT_SUCCEEDED == $this->getResult();
    }

    /**
     * Did the task fail
     * @return bool
     */
    public function isFailure()
    {
        return static::RESULT_FAILED == $this->getResult();
    }

    /**
     * Is the task Complete
     * @return bool
     */
    public function isComplete()
    {
        return $this->isSuccess() || $this->isFailure();
    }
}
