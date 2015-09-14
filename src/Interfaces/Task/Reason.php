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
 * Interface Reason
 * This should represent the reason a task succeeded or failed.
 * @package Foundry\Masonry
 */
interface Reason
{

    /**
     * Reason constructor.
     * A reason can be any string that describes why a task passed or failed.
     * @param string $reason
     */
    public function __construct($reason);

    /**
     * Get the reason
     * @return string
     */
    public function getReason();

    /**
     * Get the reason
     * @return string
     */
    public function __toString();

}