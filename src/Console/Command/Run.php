<?php
/**
 * Init.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command;

use Foundry\Masonry\Console\Command\Shared\ConfigTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Run extends Command
{

    use ConfigTrait;

    /**
     * Set up command
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('run')
            ->setDescription('Runs the currently configured masonry config.');

        $this->getNativeDefinition()->addArgument(
            $this->getConfigArgument()
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $this->getConfigFileFullPath($input);
        $output->writeln("To do");
    }
}
