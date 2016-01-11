<?php
/**
 * CoroutineRegister.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/Masonry-Builder
 */


namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\CoroutineInterface;
use Foundry\Masonry\Interfaces\CoroutineRegisterInterface;

/**
 * Class CoroutineRegister
 *
 * @package Masonry-Builder
 * @see     https://github.com/Visionmongers/Masonry-Builder
 */
class CoroutineRegister implements CoroutineRegisterInterface
{

    /**
     * @var CoroutineInterface[]
     */
    protected $coroutines = [];

    /**
     * @var int
     */
    protected $sleepTime;

    /**
     * CoroutineRegister constructor.
     * @param int $sleepTime Time in microseconds to pause between ticks.
     */
    public function __construct($sleepTime = 100)
    {
        if(!is_int($sleepTime)) {
            throw new \InvalidArgumentException('$sleepTime must be an integer');
        }
        $this->sleepTime = $sleepTime;
    }   


    /**
     * Register a Coroutine
     * @param CoroutineInterface $coroutineInterface
     * @return $this
     */
    public function register(CoroutineInterface $coroutineInterface)
    {
        if ($coroutineInterface->isValid()) {
            $this->coroutines[] = $coroutineInterface;
        }
        return $this;
    }

    /**
     * Is there anything to run
     * @return bool
     */
    public function isValid()
    {
        return count($this->coroutines) > 0;
    }

    /**
     * Loop through the generators
     * @return $this
     */
    public function tick()
    {
        foreach ($this->coroutines as $key => $coroutine) {
            $coroutine->tick();
            if (!$coroutine->isValid()) {
                unset($this->coroutines[$key]);
                continue;
            }
            usleep($this->sleepTime);
        }
        return $this;
    }
}
