<?php
/**
 * HasConfig.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Injection;

use Foundry\Masonry\Core\Config;
use Foundry\Masonry\Core\Pool;
use Foundry\Masonry\Interfaces\ConfigInterface;

/**
 * Trait HasConfig
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait HasConfig
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        if (!$this->config) {
            $this->config = new Config(new Pool([]), []);
        }
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
