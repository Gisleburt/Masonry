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
use Foundry\Masonry\Interfaces\MediatorInterface;
use Foundry\Masonry\ModuleRegister\Interfaces\ModuleRegisterInterface;
use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

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
     * @var MediatorInterface
     */
    protected static $mediator;

    /**
     * @var LoggerInterface
     */
    protected static $logger;

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
        if (self::$moduleRegister) {
            throw new \RuntimeException('Module register can only be set once. Changing it would be non-deterministic');
        }
        self::$moduleRegister = $moduleRegister;
    }

    /**
     * @return MediatorInterface
     */
    public static function getMediator()
    {
        if (!self::$mediator) {
            self::$mediator = new Mediator();
            foreach (self::getModuleRegister()->getWorkerModules() as $workerModule) {
                foreach ($workerModule->getWorkers() as $workerClassName) {
                    $worker = new $workerClassName();
                    self::$mediator->addWorker($worker);
                }
            }
        }
        return self::$mediator;
    }

    /**
     * @return LoggerInterface
     */
    public static function getLogger()
    {
        if (!self::$logger) {
            self::$logger = new NullLogger();
        }
        return self::$logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger($logger)
    {
        if (self::$logger) {
            throw new \RuntimeException('Global logger can only be set once');
        }
        self::$logger = $logger;
    }
}
