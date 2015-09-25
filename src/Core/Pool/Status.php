<?php
/**
 * StatusInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Core\Pool;

use Foundry\Masonry\Core\Exception\InvalidPoolStatus;
use Foundry\Masonry\Interfaces\Pool\StatusInterface;

/**
 * StatusInterface
 * Represents the current status of a Pool
 * @package Foundry\Masonry
 */
class Status implements StatusInterface
{

    /**
     * @var string
     */
    private $status;

    /**
     * StatusInterface constructor.
     * Must be 'pending' or 'empty'. Pending means there are tasks awaiting assignment.
     * @param $status
     * @throws InvalidPoolStatus
     */
    public function __construct($status)
    {
        $acceptableStatuses = [
            static::STATUS_PENDING,
            static::STATUS_EMPTY,
        ];
        if (!in_array($status, $acceptableStatuses)) {
            throw new InvalidPoolStatus(
                "Received status '$status'; only the following are acceptable: ".implode(', ', $acceptableStatuses)
            );
        }
        $this->status = $status;
    }

    /**
     * Returns either 'pending' or 'empty'
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
