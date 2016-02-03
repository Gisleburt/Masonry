<?php
/**
 * AbstractStatus.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core;

/**
 * Class AbstractStatus
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractStatus
{

    /**
     * @var string
     */
    protected $status;

    /**
     * Returns the current status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns status
     * @return string
     */
    public function __toString()
    {
        return $this->getStatus();
    }
}
