<?php
/**
 * AbstractCommand.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2016 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Console\Command;

use Foundry\Masonry\Console\Command\Shared\LoggerTrait;
use Foundry\Masonry\Console\Command\Shared\QueueTrait;
use Foundry\Masonry\Core\Injection\HasFilesystem;
use Symfony\Component\Console\Command\Command;

/**
 * Class AbstractCommand
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
abstract class AbstractCommand extends Command
{

    use QueueTrait;
    use LoggerTrait;
    use HasFilesystem;

    /**
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
}
