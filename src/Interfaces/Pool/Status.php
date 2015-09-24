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


namespace Foundry\Masonry\Interfaces\Pool;

/**
 * Interface Status
 * Represents the current status of a Pool
 * @package Foundry\Masonry
 */
interface Status
{

    const STATUS_PENDING  = 'pending';
    const STATUS_EMPTY    = 'empty';

    /**
     * Status constructor.
     * Must be 'pending' or 'empty'. Pending means there are tasks awaiting assignment.
     * @param $status
     */
    public function __construct($status);

    /**
     * Returns either 'pending' or 'empty'
     * @return string
     */
    public function getStatus();

    /**
     * Should return getStatus()
     * @return string
     */
    public function __toString();
}
