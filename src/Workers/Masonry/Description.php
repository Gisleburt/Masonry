<?php
/**
 * Description.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Workers\Masonry;

use Foundry\Masonry\Core\AbstractDescription;
use Foundry\Masonry\Interfaces\ConfigInterface;

/**
 * Configuring Masonry
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Description extends AbstractDescription
{

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * Description constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
}
