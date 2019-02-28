<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Collections\Contracts\CollectionInterface;

/**
 * Class Command
 *
 * @package Maduser\Minimal\Cli
 */
class Command implements CommandInterface
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $dispatcher = '';

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     *
     * @return CommandInterface
     */
    public function setPattern(string $pattern): CommandInterface
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return CommandInterface
     */
    public function setName(string $name): CommandInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return CommandInterface
     */
    public function setDescription(string $description): CommandInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDispatcher(): string
    {
        return $this->dispatcher;
    }

    /**
     * @param string $dispatcher
     *
     * @return CommandInterface
     */
    public function setDispatcher(string $dispatcher): CommandInterface
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param array $middlewares
     *
     * @return CommandInterface
     */
    public function setMiddlewares(array $middlewares): CommandInterface
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return CommandInterface
     */
    public function setClass(string $class): CommandInterface
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return CommandInterface
     */
    public function setMethod(string $method): CommandInterface
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     *
     * @return CommandInterface
     */
    public function setArguments(array $arguments): CommandInterface
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return CommandInterface
     */
    public function setOptions(array $options): CommandInterface
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $signature
     * @param array  $handler
     * @param array  $params
     *
     * @return mixed
     */
    public static function create(string $signature, array $handler, array $params = [])
    {
        $class = get_called_class();
        return new $class($signature, $handler, $params);
    }

    /**
     * Command constructor.
     *
     * @param string $pattern
     * @param array  $handler
     * @param array  $params
     */
    public function __construct(
        string $pattern,
        array $handler,
        array $params = []
    ) {
        $this->setPattern($pattern);
        $this->setHandler($handler);
        $this->setParameters($params);
    }

    /**
     * @param array $handler
     */
    public function setHandler(array $handler)
    {
        if (count($handler) > 2) {
            $this->setDispatcher($handler[0]);
            $this->setClass($handler[1]);
            $this->setMethod($handler[2]);
        }
        if (count($handler) > 1) {
            $this->setClass($handler[0]);
            $this->setMethod($handler[1]);
        }
    }

    /**
     * @param array $params
     */
    public function setParameters(array $params)
    {
        foreach ($params as $key => $value) {
            if (method_exists($this, 'set' . ucfirst($key))) {
                $this->{'set' . ucfirst($key)}($value);
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'pattern' => $this->getPattern(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'dispatcher' => $this->getDispatcher(),
            'middlewares' => $this->getMiddlewares(),
            'class' => $this->getClass(),
            'method' => $this->getMethod(),
            'arguments' => $this->getArguments(),
            'options' => $this->getOptions(),
        ];
    }

}