<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Http\Contracts\RequestInterface;

/**
 * Class AbstractCommands
 *
 * @package Maduser\Minimal\Cli
 */
class AbstractCommands implements CommandsInterface
{
    /**
     * @var ConsoleInterface
     */
    protected $console;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    public static function commands(): array
    {
        return [];
    }

    /**
     * AbstractCommands constructor.
     *
     * @param ConsoleInterface $console
     */
    public function __construct(RequestInterface $request, ConsoleInterface $console, $options)
    {
        $this->request = $request;
        $this->console = $console;
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function option($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }
}