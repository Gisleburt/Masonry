<?php
/**
 * ReasonInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Interfaces
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces\Task\History;

/**
 * Interface ReasonInterface
 * This should represent the reason a task succeeded or failed.
 * @package Foundry\Masonry
 */
interface ReasonInterface
{

    /**
     * ReasonInterface constructor.
     * A reason can be any string that describes why a task passed or failed.
     * @param string $reason
     */
    public function __construct($reason = '');

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
