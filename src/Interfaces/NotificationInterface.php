<?php
/**
 * NotificationInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Interfaces;

/**
 * Interface NotificationInterface
 *
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
interface NotificationInterface
{

    const PRIORITY_HIGH   = 0;
    const PRIORITY_NORMAL = 1;
    const PRIORITY_INFO   = 2;
    const PRIORITY_DEBUG  = 3;

    /**
     * The contents of the notification
     * @return string
     */
    public function getMessage();

    /**
     * Get the importance of the notification.
     * Lower numbers are better, 0 will always show.
     * @return int
     */
    public function getPriority();
}
