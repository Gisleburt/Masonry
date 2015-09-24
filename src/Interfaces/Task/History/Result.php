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


namespace Foundry\Masonry\Interfaces\Task\History;

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
    public function __construct($result = null);

    /**
     * Will be Succeeded, Failed or Incomplete
     * @return string
     */
    public function getResult();

    /**
     * Should return getResult()
     * @return string
     */
    public function __toString();

    /**
     * Did the task succeed
     * @return bool
     */
    public function isSuccess();

    /**
     * Did the task fail
     * @return bool
     */
    public function isFailure();

    /**
     * Is the task Complete
     * @return bool
     */
    public function isComplete();
}
