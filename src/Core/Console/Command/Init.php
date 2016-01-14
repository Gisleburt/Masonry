<?php
/**
 * Init.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Console\Command;

use Foundry\Masonry\Core\Console\Exception\FileExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Init extends Command
{

    /**
     * @var string
     */
    protected $defaultFileName = 'masonry.yaml';

    protected $configOptionName = 'config';

    /**
     * Set up command
     * @return void
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('init')
            ->setDescription('Initialise Masonry in the current directory with a masonry.yaml')
            ->addArgument(
                $this->configOptionName,
                InputArgument::OPTIONAL,
                'The name of the configuration file to use',
                $this->defaultFileName
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
        if (file_exists($fileName)) {
            throw new FileExistsException("File <comment>{$fileName}</comment> already exists");
        }

        $output->writeln("Creating <info>{$fileName}</info>");

        $config = $this->createConfigurationArray($input);
        $fs = new Filesystem("{$fileName} already exists");
        $fs->dumpFile($fileName, $config);

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
        return [];
    }
}
