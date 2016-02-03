<?php
/**
 * Init.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command;

use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Console\Exception\FileExistsException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Init extends AbstractCommand
{

    /**
     * Set up command
     * @return void
     */
    protected function configure()
    {
        $this->abstractConfigure('init', 'Initialise Masonry in the current directory with a masonry.yaml');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->setUpLogger($output);
        GlobalRegister::setLogger($logger);

        $queueFile = $this->getQueueFullPath($input);

        $filesystem = $this->getFilesystem();
        if ($filesystem->exists($queueFile)) {
            throw new FileExistsException("File '{$queueFile}' already exists");
        }

        $logger->info("Creating <info>{$queueFile}</info>");

        $filesystem->dumpFile($queueFile, '');

        $logger->info("Done");
    }
}
