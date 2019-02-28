<?php
/**
 * CommandInterface.php
 * 2/25/19 - 3:46 PM
 *
 * PHP version 7
 *
 * @package    @package_name@
 * @author     Julien Duseyau <julien.duseyau@gmail.com>
 * @copyright  2019 Julien Duseyau
 * @license    https://opensource.org/licenses/MIT
 * @version    Release: @package_version@
 *
 * The MIT License (MIT)
 *
 * Copyright (c) Julien Duseyau <julien.duseyau@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Maduser\Minimal\Cli;


/**
 * Class Command
 *
 * @package Maduser\Minimal\Cli
 */
interface CommandInterface
{
    /**
     * @return string
     */
    public function getPattern(): string;

    /**
     * @param string $pattern
     *
     * @return CommandInterface
     */
    public function setPattern(string $pattern): CommandInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     *
     * @return CommandInterface
     */
    public function setName(string $name): CommandInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     *
     * @return CommandInterface
     */
    public function setDescription(string $description): CommandInterface;

    /**
     * @return string
     */
    public function getDispatcher(): string;

    /**
     * @param string $dispatcher
     *
     * @return CommandInterface
     */
    public function setDispatcher(string $dispatcher): CommandInterface;

    /**
     * @return array
     */
    public function getMiddlewares(): array;

    /**
     * @param array $middlewares
     *
     * @return CommandInterface
     */
    public function setMiddlewares(array $middlewares): CommandInterface;

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @param string $class
     *
     * @return CommandInterface
     */
    public function setClass(string $class): CommandInterface;

    /**
     * @return string
     */
    public function getMethod(): string;

    /**
     * @param string $method
     *
     * @return CommandInterface
     */
    public function setMethod(string $method): CommandInterface;

    /**
     * @return array
     */
    public function getArguments(): array;

    /**
     * @param array $arguments
     *
     * @return CommandInterface
     */
    public function setArguments(array $arguments): CommandInterface;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param array $options
     *
     * @return CommandInterface
     */
    public function setOptions(array $options): CommandInterface;

    /**
     * @param string $signature
     * @param array  $handler
     * @param array  $params
     *
     * @return mixed
     */
    public static function create(string $signature, array $handler, array $params = []);

    /**
     * @param array $handler
     */
    public function setHandler(array $handler);

    /**
     * @param array $params
     */
    public function setParameters(array $params);

    /**
     * @return array
     */
    public function toArray();
}