<?php
/**
 * AbstractCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command;

use Foundry\Masonry\Core\Injection\HasFilesystem;
use Foundry\Masonry\Logging\MultiLogger;
use Foundry\Masonry\Logging\SymfonyOutputLogger;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractCommand extends Command
{

    use HasFilesystem;

    /**
     * @var string
     */
    protected $defaultFileName = 'queue.yaml';

    /**
     * @var string
     */
    protected $configOptionName = 'queue';

    /**
     * Sets up the command
     * @param string $name
     * @param string $description
     */
    protected function abstractConfigure($name, $description)
    {
        parent::configure();

        $this
            ->setName($name)
            ->setDescription($description);

        $this->getNativeDefinition()->addArgument(
            $this->getQueueArgument()
        );
    }

    /**
     * @param OutputInterface $output
     * @return MultiLogger
     */
    protected function setUpLogger(OutputInterface $output)
    {
        $logger = new MultiLogger();
        $logger->addLogger(
            new SymfonyOutputLogger($output)
        );
        return $logger;
    }

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
