<?php
/**
 * TaskInterfaceInterface.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;

use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\Task\History\ReasonInterface;

interface TaskInterface
{

    /**
     * Construct a task, give it a description
     * @param DescriptionInterface $description
     */
    public function __construct(DescriptionInterface $description);

    /**
     * Returns the data for the worker to use.
     * This data is generally bespoke.
     * @return Task\DescriptionInterface
     */
    public function getDescription();

    /**
     * The current status of this task
     * @return Task\StatusInterface
     */
    public function getStatus();

    /**
     * The history of this task
     * @return Task\HistoryInterface
     */
    public function getHistory();

    /**
     * Notify the task that work has begun
     * @return $this
     */
    public function start();

    /**
     * Complete the task
     * @param ReasonInterface $reason
     * @return $this
     */
    public function complete(ReasonInterface $reason);

    /**
     * Cancel the task (might be able to do it later)
     * @param ReasonInterface $reason
     * @return $this
     */
    public function cancel(ReasonInterface $reason);
}
