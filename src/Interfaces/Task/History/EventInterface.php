<?php
/**
 * EventInterface.php
 * PHP version 5.4
 * 2015-09-14
 *
 * @package   Foundry\Masonry
 * @category  Interfaces
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task\History;

/**
 * Interface EventInterface
 *
 * @package Foundry\Masonry
 */
interface EventInterface
{

    /**
     * Creates a new event, starting the timer immediately
     */
    public function __construct();

    /**
     * Run this when the task ends, providing a result and optionally a reason
     * @param ResultInterface $result
     * @param ReasonInterface $reason
     * @return mixed
     */
    public function endEvent(ResultInterface $result, ReasonInterface $reason = null);

    /**
     * The time at which the task was started.
     * This must return a time seconds as a float.
     * @return float
     */
    public function getStartTime();

    /**
     * The time at which the task ended.
     * This must return a time in seconds as a float.
     * @return float
     */
    public function getEndTime();

    /**
     * The result of the task when it was run.
     * @return ResultInterface
     */
    public function getResult();

    /**
     * Reason for result.
     * @return ReasonInterface
     */
    public function getReason();

    /**
     * Returns the history in string form, useful for logging
     * Eg "[{$this->getStartTime())} - {$this->getEndTime()}][{$this->getResult()}] {$this->getReason()}"
     * @return string
     */
    public function __toString();
}
