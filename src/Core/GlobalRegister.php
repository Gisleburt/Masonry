<?php
/**
 * GlobalRegisterInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\GlobalRegisterInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegister as ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\ModuleRegister;

/**
 * Class GlobalRegister
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class GlobalRegister implements GlobalRegisterInterface
{
    /**
     * @var ModuleRegisterInterface
     */
    protected static $moduleRegister;

    /**
     * @return ModuleRegisterInterface
     */
    public static function getModuleRegister()
    {
        if (!self::$moduleRegister) {
            self::$moduleRegister = ModuleRegister::load();
        }
        return self::$moduleRegister;
    }

    /**
     * @param ModuleRegisterInterface $moduleRegister
     */
    public static function setModuleRegister($moduleRegister)
    {
        self::$moduleRegister = $moduleRegister;
    }
}
