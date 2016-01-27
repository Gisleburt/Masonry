<?php
/**
 * GlobalRegisterInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Interfaces;

use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegister as ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\ModuleRegister;

/**
 * Interface GlobalRegister
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
interface GlobalRegisterInterface
{

    /**
     * @return ModuleRegisterInterface
     */
    public static function getModuleRegister();

    /**
     * @param ModuleRegisterInterface $moduleRegister
     */
    public static function setModuleRegister($moduleRegister);
}
