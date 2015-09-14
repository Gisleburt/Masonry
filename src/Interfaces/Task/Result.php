<?php
/**
 * Reason.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

/**
 * Interface Result
 * The result of the task. Can be 'succeeded', 'failed' or 'incomplete'.
 * @package Foundry\Masonry
 */
interface Result
{

    const RESULT_SUCCEEDED  = 'succeeded';
    const RESULT_FAILED     = 'failed';
    const RESULT_INCOMPLETE = 'incomplete';

    /**
     * Result constructor.
     * Should be instantiate with 'succeeded' of 'failed', otherwise it will be 'incomplete'
     * @param $result
     */
    public function __construct($result);

    /**
     * Will be Succeeded, Failed or Incomplete
     * @return mixed
     */
    public function getReason();

    /**
     * For comparing to strings
     * @return mixed
     */
    public function __toString();

    /**
     * Did the task succeed
     * @return bool
     */
    public function didSucceed();

    /**
     * Did the task fail
     * @return bool
     */
    public function didFail();

    /**
     * Is the task Complete
     * @return bool
     */
    public function isComplete();

}