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
use Foundry\Masonry\Console\Exception\FileExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Dumper;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Init extends Command
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
            ->setName('init')
            ->setDescription('Initialise Masonry in the current directory with a masonry.yaml');

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

        $fs = new Filesystem();
        if ($fs->exists($configFile)) {
            throw new FileExistsException("File <comment>{$configFile}</comment> already exists");
        }

        $output->writeln("Creating <info>{$configFile}</info>");

        $fs->dumpFile(
            $configFile,
            $this->toYaml(
                $this->createConfigurationArray($input)
            )
        );

        $output->writeln("Done");
    }
    /**
     * @return array
     */
    protected function createConfigurationArray(InputInterface $input)
    {
        $config = $this->getConfig();
        return $config->toArray();
    }

    /**
     * Convert an array to a Yaml string
     * @param array $data
     * @return string
     */
    protected function toYaml(array $data)
    {
        $yamlDumper = new Dumper();
        return $yamlDumper->dump($data, 10);
    }
}
