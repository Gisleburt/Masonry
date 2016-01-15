<?php
/**
 * Init.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Console\Command;

use Foundry\Masonry\Core\Console\Command\Shared\Config;
use Foundry\Masonry\Core\Console\Exception\FileExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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

    use Config;


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
        $fileName = $this->getCwd() . DIRECTORY_SEPARATOR . $input->getArgument($this->configOptionName);

        $fs = new Filesystem();
        if ($fs->exists($fileName)) {
            throw new FileExistsException("File <comment>{$fileName}</comment> already exists");
        }

        $output->writeln("Creating <info>{$fileName}</info>");

        $fs->dumpFile(
            $fileName,
            $this->toYaml(
                $this->createConfigurationArray($input)
            )
        );

        $output->writeln("Done");
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
