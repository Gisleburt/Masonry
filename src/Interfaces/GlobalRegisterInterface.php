<?php
/**
 * GlobalRegisterInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Interfaces;

use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;
use Psr\Log\LoggerInterface;

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
    public static function setModuleRegister(ModuleRegisterInterface $moduleRegister);

    /**
     * @return MediatorInterface
     */
    public static function getMediator();

    /**
     * @return LoggerInterface
     */
    public static function getLogger();

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger);
}
