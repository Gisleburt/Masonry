<?php
/**
 * Config.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command\Shared;

use Foundry\Masonry\Core\Injection\HasConfig;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class Config
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait QueueTrait
{

    use HasConfig;

    /**
     * @var string
     */
    protected $defaultFileName = 'queue.yaml';

    protected $configOptionName = 'queue';

    /**
     * @return InputArgument
     */
    protected function getQueueArgument()
    {
        return new InputArgument(
            $this->configOptionName,
            InputArgument::OPTIONAL,
            'The name of the initial queue to use',
            $this->defaultFileName
        );
    }

    /**
     * @param InputInterface|null $input
     * @return string
     */
    protected function getQueueFullPath(InputInterface $input = null)
    {
        if ($input && $input->hasArgument($this->configOptionName)) {
            return $input->getArgument($this->configOptionName);
        }
        return $this->defaultFileName;
    }

    /**
     * Gets the current working directory
     * Just a wrapper in case we need to do something more complex
     * @return string
     */
    protected function getCwd()
    {
        return getcwd();
    }
}
