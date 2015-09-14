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

    const STATUS_ACTIVE   = 'active';
    const STATUS_COMPLETE = 'complete';
    const STATUS_WAITING  = 'waiting';

    public function __construct($status);

    public function getStatus();
}