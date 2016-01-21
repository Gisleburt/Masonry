<?php
/**
 * ConfigInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Interfaces;

/**
 * Class ConfigInterface
 * What needs to be available to the configuration
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
interface ConfigInterface
{
    /**
     * @return WorkerModuleInterface
     */
    public function getWorkerModules();

    /**
     * @return PoolInterface
     */
    public function getPool();

    /**
     * In order to load and save the config, it should be transformable to an array.
     * @return array
     */
    public function toArray();
}
