<?php
/**
 * Config.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core;

use Foundry\Masonry\Interfaces\ConfigInterface;
use Foundry\Masonry\Interfaces\PoolInterface;
use Foundry\Masonry\Interfaces\WorkerModuleInterface;

/**
 * Class Config
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Config extends AbstractDescription implements ConfigInterface
{

    /**
     * @var PoolInterface
     */
    protected $pool;

    /**
     * @var WorkerModuleInterface[]
     */
    protected $workerModules;

    /**
     * Config constructor.
     * @param PoolInterface $pool
     * @param WorkerModuleInterface[] $workerModules
     */
    public function __construct(PoolInterface $pool, array $workerModules)
    {
        foreach ($workerModules as $workerModule) {
            if (!$workerModule instanceof WorkerModuleInterface) {
                throw new \InvalidArgumentException(
                    "All worker modules must implement " . WorkerModuleInterface::class
                );
            }
        }

        $this->pool = $pool;
        $this->workerModules = $workerModules;
    }

    /**
     * @return PoolInterface
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @return WorkerModuleInterface[]
     */
    public function getWorkerModules()
    {
        return $this->workerModules;
    }

    /**
     * This method acts as the counterpart to ::createFromParameters
     * @return array
     */
    public function toArray()
    {
        return [
            'pool' => $this->getPool(),
            'workerModules' => $this->getWorkerModules(),
        ];
    }
}
