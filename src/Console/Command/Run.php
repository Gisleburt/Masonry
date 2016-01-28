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
use Foundry\Masonry\Console\Exception\FileExistsException;
use Foundry\Masonry\Core\GlobalRegister;
use Foundry\Masonry\Core\Injection\HasFilesystem;
use Foundry\Masonry\Core\Mediator;
use Foundry\Masonry\Core\Task;
use Foundry\Masonry\ModuleRegister\ModuleRegister;
use Foundry\Masonry\Workers\Group\Serial\Description;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Init
 * Initialise Masonry in the current directory with a masonry.yaml
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
class Run extends Command
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
            ->setName('run')
            ->setDescription('Runs the currently configured masonry config.');

        $this->getNativeDefinition()->addArgument(
            $this->getQueueArgument()
        );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws FileExistsException
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->setUpLogger($output);
        GlobalRegister::setLogger($logger);

        // Should be able to specify a different module registry?
        $logger->info("Setting up module register");
        $moduleRegister = ModuleRegister::load();
        GlobalRegister::setModuleRegister($moduleRegister);

        // Get the queue file
        $logger->info("Loading queue");
        $fs = $this->getFilesystem();
        $queueFile = $this->getQueueFullPath($input);
        if (!$fs->exists($queueFile)) {
            throw new FileExistsException("File '{$queueFile}' doesn't exist, run 'masonry init' to create one");
        }

        // Process the pool
        $logger->info("Processing queue");
        $mediator = new Mediator();
        $taskArray = (array)Yaml::parse(file_get_contents($queueFile));
        $mediator->process(
            new Task(
                new Description($taskArray)
            )
        );

        $logger->info('done');
    }
}
