<?php
/**
 * StatusInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Interfaces
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task;

/**
 * Interface StatusInterface
 * Represents the current status of a Task
 * @package Foundry\Masonry
 */
interface StatusInterface
{

    const STATUS_NEW         = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETE    = 'complete';
    const STATUS_DEFERRED    = 'deferred';
    const STATUS_FAILED      = 'failed';

    /**
     * StatusInterface constructor.
     * Must be 'new', 'in progress', 'complete', or 'deferred'.
     * @param $status
     */
    public function __construct($status = null);

    /**
     * Returns 'new', 'in progress', 'complete', or 'deferred'.
     * @return string
     */
    public function getStatus();

    /**
     * Should return getStatus()
     * @return string
     */
    public function __toString();
}
