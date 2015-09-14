<?php
/**
 * Scribe.php
 * PHP version 5.4
 * 2015-09-04
 *
 * @package   Masonry
 * @category
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 */


namespace Foundry\Masonry\Interfaces;

interface Scribe
{

    /**
     * Write a string to an output (file, screen etc)
     * @param string $message The message to be written
     * @param string $classification
     * @return mixed
     */
    public function write($message, $classification = null);

}