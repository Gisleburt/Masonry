<?php
/**
 * Coroutine.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Core\Exception\InvalidCoroutine;
use Foundry\Masonry\Interfaces\CoroutineInterface;
use React\Promise\Deferred;
use React\Promise\Promise;

/**
 * Class Coroutine
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Coroutine implements CoroutineInterface
{

    /**
     * @var Deferred
     */
    protected $deferred;

    /**
     * @var \Generator
     */
    protected $generator;

    /**
     * Coroutine constructor.
     * @param Deferred $deferred
     * @param \Generator $generator
     */
    public function __construct(Deferred $deferred, \Generator $generator = null)
    {
        $this->deferred = $deferred;
        $this->generator = $generator;
    }


    /**
     * Processes the coroutine one step
     * @throws InvalidCoroutine
     * @return mixed
     */
    public function tick()
    {
        if (!$this->isValid()) {
            throw new InvalidCoroutine();
        }
        $returnValue = $this->generator->current();
        $this->generator->next();
        return $returnValue;
    }

    /**
     * Get a promise that the work will be done
     * @return Promise
     */
    public function getPromise()
    {
        return $this->deferred->promise();
    }

    /**
     * Is the coroutine in a valid state
     * If the coroutine has finished, this will return false.
     * @return boolean
     */
    public function isValid()
    {
        return $this->generator && $this->generator->valid();
    }
}
