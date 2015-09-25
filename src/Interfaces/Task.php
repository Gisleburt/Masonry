<?php
/**
 * Task.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;

interface Task
{

    /**
     * Returns the data for the worker to use.
     * This data is generally bespoke.
     * @return Task\DescriptionInterface
     */
    public function getDescription();

    /**
     * The current status of this task
     * @return Task\Status
     */
    public function getStatus();

    /**
     * The history of this task
     * @return Task\HistoryInterface
     */
    public function getHistory();
}
