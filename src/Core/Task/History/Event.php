<?php
/**
 * ReasonInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core\Task\History;

use Foundry\Masonry\Interfaces\Task\History\EventInterface;
use Foundry\Masonry\Interfaces\Task\History\ReasonInterface;
use Foundry\Masonry\Interfaces\Task\History\ResultInterface;

/**
 * Class Event
 * This should represent an event in the tasks history.
 * @package Foundry\Masonry
 */
class Event implements EventInterface
{
    /**
     * @var float
     */
    private $startTime;

    /**
     * @var float
     */
    private $endTime;

    /**
     * @var ResultInterface
     */
    private $result;

    /**
     * @var ReasonInterface
     */
    private $reason;

    public function __construct() {
        $this->startTime = microtime(true);
        $this->endTime = 0.0;
        $this->result = new Result();
        $this->reason = new Reason();
    }

    /**
     * Run this when the task ends, providing a result and optionally a reason
     * @param ResultInterface $result
     * @param ReasonInterface $reason
     * @return $this
     */
    public function endEvent(ResultInterface $result, ReasonInterface $reason = null)
    {
        $this->endTime = microtime(true);
        $this->result = $result;
        if($reason) {
            $this->reason = $reason;
        }
        return $this;
    }

    /**
     * The time at which the task was started.
     * This must return a microtime as a float.
     * @return float
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * The time at which the task ended.
     * This must return a microtime as a float.
     * @return float
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * The result of the task when it was run.
     * @return ResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Reason for result.
     * @return ReasonInterface
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Returns the history in string form, useful for logging
     * Eg "[{$this->getStartTime()} - {$this->getEndTime()}][{$this->getResult()}] {$this->getReason()}"
     * @return string
     */
    public function __toString()
    {
        return "[{$this->getStartTime()} - {$this->getEndTime()}][{$this->getResult()}] {$this->getReason()}";
    }

}
