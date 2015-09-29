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


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Core\Task\History;
use Foundry\Masonry\Core\Task\Status;
use Foundry\Masonry\Interfaces\Task\DescriptionInterface;
use Foundry\Masonry\Interfaces\Task\History\ResultInterface;
use Foundry\Masonry\Interfaces\Task\HistoryInterface;
use Foundry\Masonry\Interfaces\Task\StatusInterface;
use Foundry\Masonry\Interfaces\Task\History\ReasonInterface;
use Foundry\Masonry\Interfaces\TaskInterface;

class Task implements TaskInterface
{
    /**
     * @var DescriptionInterface
     */
    private $description;

    /**
     * @var History
     */
    private $history;

    /**
     * Construct a task, give it a description
     * @param DescriptionInterface $description
     */
    public function __construct(DescriptionInterface $description)
    {
        $this->description = $description;
    }

    /**
     * Returns the data for the worker to use.
     * This data is generally bespoke.
     * @return DescriptionInterface
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * The current status of this task
     * @return StatusInterface
     */
    public function getStatus()
    {
        if(!$this->getHistory()->getEvents()) {
            return new Status(Status::STATUS_NEW);
        }
        if(!$this->getHistory()->getLastEvent()->getEndTime()) {
            return new Status(Status::STATUS_IN_PROGRESS);
        }
        if($this->getHistory()->getLastEvent()->getResult() == ResultInterface::RESULT_INCOMPLETE) {
            return new Status(Status::STATUS_DEFERRED);
        }
        return new Status(Status::STATUS_COMPLETE);
    }

    /**
     * The history of this task
     * @return HistoryInterface
     */
    public function getHistory()
    {
        if(!$this->history) {
            $this->history = new History();
        }
        return $this->history;
    }

    /**
     * Notify the task that work has begun
     * @return $this
     */
    public function start()
    {
        $this->getHistory()->addEvent(
            new History\Event()
        );
        return $this;
    }

    /**
     * Complete the task
     * @param ResultInterface|null $result Defaults to succeeded
     * @param ReasonInterface|null $reason Defaults to empty
     * @return $this
     */
    public function complete(ResultInterface $result = null, ReasonInterface $reason = null)
    {
        if(!$result) {
            $result = new History\Result(History\Result::RESULT_SUCCEEDED);
        }
        $this->getHistory()->getLastEvent()->endEvent($result, $reason);
        return $this;
    }

    /**
     * Cancel the task (might be able to do it later)
     * @param ReasonInterface $reason
     * @return $this
     */
    public function cancel(ReasonInterface $reason = null)
    {
        $this->getHistory()->getLastEvent()->endEvent(
            new History\Result(History\Result::RESULT_INCOMPLETE),
            $reason
        );
        return $this;
    }
}
