<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Facades\Router;

class Commands
{
    protected $commands;

    public function __construct(CollectionInterface $collection)
    {
        $this->commands = $collection;
    }

    public function register(array $classes)
    {
        foreach ($classes as $class) {
            foreach ($class::commands() as $command) {
                /** @var Command $command */
                Router::cli($command->getPattern(), [
                    'name' => $command->getName(),
                    'description' => $command->getDescription(),
                    'dispatcher' => $command->getDispatcher(),
                    'middlewares' => $command->getMiddlewares(),
                    'controller' => $command->getClass(),
                    'action' => $command->getMethod(),
                    'arguments' => $command->getArguments(),
                    'options' => $command->getOptions(),
                ]);
            }
        }
    }

    public function dispatch(string $command, array $args = [])
    {
        $command = $this->commands->get($command);
        call_user_func_array([$command, $command->geName()], [$args]);
    }

}