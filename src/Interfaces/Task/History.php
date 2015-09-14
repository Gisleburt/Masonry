<?php
/**
 * History.php
 * PHP version 5.4
 * 2015-09-14
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;


interface History
{

    /**
     * The time at which the task was started.
     * This must return a microtime as a float.
     * @return float
     */
    public function getStartTime();

    /**
     * The time at which the task ended.
     * This must return a microtime as a float.
     * @return float
     */
    public function getEndTime();

    /**
     * The result of the task when it was run.
     * @return Result
     */
    public function getResult();

    /**
     * Reason for result.
     * @return Reason
     */
    public function getReason();

    /**
     * Returns the history in string form, useful for logging
     * Eg "[{$this->getStartTime())} - {$this->getEndTime()}][{$this->getResult()}] {$this->getReason()}"
     * @return string
     */
    public function __toString();

    /**
     * Run this when the task is started
     * @return $this
     */
    public function start();

    /**
     * Run this when the task ends, providing a result and a reason
     * @param Result $result
     * @param Reason $reason
     * @return mixed
     */
    public function stop(Result $result, Reason $reason);

}