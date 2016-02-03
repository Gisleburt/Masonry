<?php
/**
 * Status.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Foundry\Masonry
 * @category  Core
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core\Task;

use Foundry\Masonry\Core\AbstractStatus;
use Foundry\Masonry\Core\Exception\InvalidTaskStatus;
use Foundry\Masonry\Interfaces\Task\StatusInterface;

/**
 * Class Status
 * Represents the current status of a Task
 * @package Foundry\Masonry
 */
class Status extends AbstractStatus implements StatusInterface
{
    /**
     * StatusInterface constructor.
     * Must be 'new', 'in progress', 'complete', or 'deferred'.
     * @param $status
     */
    public function __construct($status = null)
    {
        if (!$status) {
            $status = static::STATUS_NEW;
        }
        $acceptableStatuses = [
            static::STATUS_NEW,
            static::STATUS_IN_PROGRESS,
            static::STATUS_COMPLETE,
            static::STATUS_DEFERRED,
            static::STATUS_FAILED,
        ];
        if (!in_array($status, $acceptableStatuses)) {
            throw new InvalidTaskStatus();
        }
        $this->status = $status;
    }
}
