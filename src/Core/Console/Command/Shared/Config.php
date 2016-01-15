<?php
/**
 * Config.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Console\Command\Shared;

use Foundry\Masonry\Core\Injection\HasConfig;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Config
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait Config
{

    use HasConfig;

    /**
     * @var string
     */
    protected $defaultFileName = 'masonry.yaml';

    protected $configOptionName = 'config';

    /**
     * @return InputArgument
     */
    protected function getConfigArgument()
    {
        return new InputArgument(
            $this->configOptionName,
            InputArgument::OPTIONAL,
            'The name of the configuration file to use',
            $this->defaultFileName
        );
    }

}
