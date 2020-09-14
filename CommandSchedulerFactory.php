<?php

namespace Xact\CommandScheduler;

use Cron\CronExpression;
use InvalidArgumentException;
use Xact\CommandScheduler\Entity\ScheduledCommand;

class CommandSchedulerFactory
{
    /**
     * Create a command to run immediately
     */
    public static function createImmediateCommand(string $description, string $command, ?string $arguments) : ScheduledCommand
    {
        $scheduledCommand = new ScheduledCommand();
        $scheduledCommand->setDescription($description);
        $scheduledCommand->setCommand($command);
        $scheduledCommand->setArguments($arguments);
        $scheduledCommand->setRunImmediately(true);

        return $scheduledCommand;
    }

    /**
     * Create a command scheduled by a CRON expression
     */
    public static function createCronCommand(string $cronExpression, string $description, string $command, ?string $arguments) : ScheduledCommand
    {
        if (!CronExpression::isValidExpression($cronExpression)) {
            throw new InvalidArgumentException("The cron expression '{$cronExpression}' is invalid");
        }

        $scheduledCommand = new ScheduledCommand();
        $scheduledCommand->setCronExpression($cronExpression);
        $scheduledCommand->setDescription($description);
        $scheduledCommand->setCommand($command);
        $scheduledCommand->setArguments($arguments);

        return $scheduledCommand;
    }
}