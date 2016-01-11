<?php
/**
 * TestDeferred.php
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/TheFoundryVisionmongers/Masonry-Builder
 */


namespace Foundry\Masonry\Tests\PhpUnit;

use React\Promise\Deferred;

/**
 * Class TestDeferred
 * For simplifying tests
 * @package   Masonry
 * @see       https://github.com/TheFoundryVisionmongers/Masonry
 */
class DeferredWrapper
{

    /**
     * @var Deferred
     */
    protected $deferred;

    /**
     * @var mixed
     */
    protected $successOutput;

    /**
     * @var mixed
     */
    protected $failureOutput;

    /**
     * @var mixed
     */
    protected $notificationOutput;

    /**
     * @var bool
     */
    protected $complete = false;

    /**
     * TestDeferred constructor.
     */
    public function __construct()
    {
        $successClosure = function ($output) {
            $this->successOutput = $output;
        };
        $failureClosure = function ($output) {
            $this->failureOutput = $output;
        };
        $notifyClosure = function ($output) {
            $this->notificationOutput = $output;
        };
        $doneClosure = function () {
            $this->complete= true;
        };

        $this->deferred = new Deferred();
        $this->deferred->promise()
            ->then($successClosure)
            ->otherwise($failureClosure)
            ->progress($notifyClosure)
            ->done($doneClosure);
    }

    /**
     * @return Deferred
     */
    public function getDeferred()
    {
        return $this->deferred;
    }

    /**
     * @return mixed
     */
    public function getSuccessOutput()
    {
        return $this->successOutput;
    }

    /**
     * @return mixed
     */
    public function getFailureOutput()
    {
        return $this->failureOutput;
    }

    /**
     * @return mixed
     */
    public function getNotificationOutput()
    {
        return $this->notificationOutput;
    }

    /**
     * @return boolean
     */
    public function isComplete()
    {
        return $this->complete;
    }

}
