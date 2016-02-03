<?php
/**
 * ModuleInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Interfaces;

/**
 * Interface ModuleInterface
 * Worker modules act as a single worker, but mediate the work to other child workers.
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
interface WorkerModuleInterface extends WorkerInterface, MediatorInterface
{

}
