<?php
/**
 * Init.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command;

use Foundry\Masonry\Console\Command\Shared\LoggerTrait;
use Foundry\Masonry\Console\Command\Shared\QueueTrait;
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Core\Injection\HasFilesystem;
use Foundry\Masonry\Console\Exception\FileExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Init extends Command
{

    use QueueTrait;
    use LoggerTrait;
    use HasFilesystem;


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
            $this->getQueueArgument()
        );
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

        $fs = $this->getFilesystem();
        if ($fs->exists($queueFile)) {
            throw new FileExistsException("File '{$queueFile}' already exists");
        }

        $logger->info("Creating <info>{$queueFile}</info>");

        $fs->dumpFile($queueFile, '');

        $logger->info("Done");
    }
}
