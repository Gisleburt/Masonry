<?php
/**
 * MediatorAwareTrait.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */


namespace Foundry\Masonry\Core\Mediator;

use Foundry\Masonry\Interfaces\MediatorInterface;

/**
 * Trait MediatorAwareTrait
 * ${CARET}
 * @package Masonry
 * @see     https://github.com/TheFoundryVisionmongers/Masonry
 */
trait MediatorAwareTrait
{

    /**
     * @var MediatorInterface
     */
    private $mediator;

    /**
     * @return MediatorInterface
     */
    protected function getMediator()
    {
        return $this->mediator;
    }

    /**
     * @param MediatorInterface $mediator
     * @return $this
     */
    public function setMediator(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
        return $this;
    }
}
