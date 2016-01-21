<?php
/**
 * HasFilesystem.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */

namespace Foundry\Masonry\Core\Injection;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class HasFilesystem
 * Is anyone else annoyed at how Symfony failed to camel case this?
 * Should this be in core?
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait HasFilesystem
{

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        if (!$this->filesystem) {
            $this->filesystem = new Filesystem();
        }
        return $this->filesystem;
    }

    /**
     * @param Filesystem $filesystem
     * @return $this
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;
        return $this;
    }
}
