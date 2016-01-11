<?php
/**
 * CoroutineInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Builder
 */


namespace Foundry\Masonry\Interfaces;

use React\Promise\Promise;

/**
 * Interface CoroutineInterface
 * This is a value class that
 * @package Masonry-Builder
 * @see     https://github.com/TheFoundryVisionmongers/Masonry-Builder
 */
interface CoroutineInterface
{

    /**
     * Processes the coroutine one step
     * May return a value
     * @return mixed
     */
    public function tick();

    /**
     * Get a promise that the work will be done
     * @return Promise
     */
    public function getPromise();

    /**
     * Is the coroutine in a valid state
     * If the coroutine has finished, this will return false.
     * @return boolean
     */
    public function isValid();
}
