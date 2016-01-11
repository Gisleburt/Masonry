<?php
/**
 * MediatorAwareInterface.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Interfaces\Mediator;

use Foundry\Masonry\Interfaces\MediatorInterface;

/**
 * Interface MediatorAwareInterface
 *
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
interface MediatorAwareInterface
{

    /**
     * Sets a mediator to be used by the class.
     * The mediator should be pre-populated.
     * @param MediatorInterface $mediator
     * @return $this
     */
    public function setMediator(MediatorInterface $mediator);
}
