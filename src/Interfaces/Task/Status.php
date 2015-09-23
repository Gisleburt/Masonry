<?php
/**
 * Status.php
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
 * Interface Status
 * Represents the current status of a Pool
 * @package Foundry\Masonry
 */
interface Status
{

    const STATUS_NEW         = 'new';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETE    = 'complete';
    const STATUS_DEFERRED    = 'deferred';

    /**
     * Status constructor.
     * Must be 'new', 'in progress', 'complete', or 'deferred'.
     * @param $status
     */
    public function __construct($status);

    /**
     * Returns 'new', 'in progress', 'complete', or 'deferred'.
     * @return string
     */
    public function getStatus();

    /**
     * Returns status
     * @return string
     */
    public function __toString();
}