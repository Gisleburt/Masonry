<?php
/**
 * SymfonyOutputLogger.php
 *
 * @author    Daniel Mason <daniel.mason@thefoundry.co.uk>
 * @copyright 2015 The Foundry Visionmongers
 * @license
 * @see       https://github.com/Visionmongers/
 */


namespace Foundry\Masonry\Logging;

use Foundry\Masonry\Core\Notification;
use Foundry\Masonry\Interfaces\NotificationInterface;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SymfonyOutputLogger
 * @package Foundry\Masonry-Builder
 * @see     https://github.com/Visionmongers/
 */
class SymfonyOutputLogger extends AbstractSimpleLogger
{

    const MIN_SIZE = 7;

    protected $output;

    /**
     * The time in seconds when execution started
     * @var float
     */
    protected $startTime;

    public function __construct(OutputInterface $output)
    {
        $this->startTime = $this->getMicroTime();
        $this->output = $output;
    }

    /**
     * Apply decorators to the level
     * Adds the timestamp if verbosity is set to debug
     * @param $level
     * @return string
     */
    protected function decorateLevel($level)
    {
        $decoratedLevel = parent::decorateLevel($level);

        if ($this->output->getVerbosity() == OutputInterface::VERBOSITY_DEBUG) {
            //if we are in debug verbosity mode, append timestamps to the level output
            $timeElapsed = $this->getTimeElapsed();
            $decoratedLevel = "[ " . $this->decorateTimeElapsed($timeElapsed) . "s ] " . $decoratedLevel;
        }

        return $decoratedLevel;
    }

    /**
     * A wrapper around microtime
     * @return mixed
     */
    protected function getMicroTime()
    {
        return microtime(true);
    }

    /**
     * Get the time elapsed since the start of the script execution
     * @param int $precision The rounding precision, default to 3
     * @return float Time elapsed since the start of the script execution, in seconds
     */
    protected function getTimeElapsed($precision = 3)
    {
        return round($this->getMicroTime() - $this->startTime, $precision);
    }

    /**
     * Decorate the time elapsed
     * @param float $timeElapsed Time elapsed
     * @param int  $padding      Padding value
     * @return string Decorated elapsed time string
     */
    protected function decorateTimeElapsed($timeElapsed, $padding = 8)
    {
        return sprintf("%'. {$padding}.3f", $timeElapsed);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        if (!$message instanceof NotificationInterface) {
            $message = new Notification($message);
        }

        $outputVerbosity = $this->output->getVerbosity();
        if ($outputVerbosity >= $message->getPriority()) {
            // Switch off Quiet if it's on
            if ($outputVerbosity == OutputInterface::VERBOSITY_QUIET) {
                $this->output->setVerbosity(OutputInterface::VERBOSITY_NORMAL);
                $this->output->writeln($this->formatLog($level, $message));
                $this->output->setVerbosity($outputVerbosity);
                return;
            }
            $this->output->writeln($this->formatLog($level, $message));
        }
    }

    /**
     * Apply a colour based on the level
     * Use symfony colors
     * @param $level
     * @param $textToColor
     * @return string
     */
    protected function colorForLevel($level, $textToColor)
    {
        switch ($level) {
            case LogLevel::NOTICE:
                return "<fg=yellow>$textToColor</>";
                break;
            case LogLevel::INFO:
                return "<fg=green>$textToColor</>";
                break;
            case LogLevel::DEBUG:
                return "<fg=cyan>$textToColor</>";
                break;
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
            case LogLevel::WARNING:
            default:
        }
        return "<fg=red>$textToColor</>";
    }


    /**
     * Translate the word
     * @param $level
     * @return string
     */
    protected function translateLevel($level)
    {
        switch ($level) {
            case LogLevel::INFO:
                return "Success";
            case LogLevel::ERROR:
                return "Failure";
            case LogLevel::DEBUG:
            case LogLevel::NOTICE:
                return ucwords(strtolower($level));
                break;
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::WARNING:
            default:
                return strtoupper($level);
                break;
        }
    }
}
