<?php
/**
 * CoroutineRegisterInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Interfaces;

/**
 * Interface CoroutineRegisterInterface
 *
 * @package Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
interface CoroutineRegisterInterface
{

    /**
     * Register a Coroutine
     * @param CoroutineInterface $coroutineInterface
     * @return $this
     */
    public function register(CoroutineInterface $coroutineInterface);

    /**
     * Is there anything to run
     * @return bool
     */
    public function isValid();

    /**
     * Loop through the generators
     * @return $this
     */
    public function tick();
}
