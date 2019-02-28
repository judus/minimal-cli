<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Cli\AbstractCommands;
use Maduser\Minimal\Cli\Command;
use Maduser\Minimal\Cli\Console;
use Maduser\Minimal\Collections\Collection;
use Maduser\Minimal\Collections\Contracts\CollectionInterface;
use Maduser\Minimal\Event\Subscriber;
use Maduser\Minimal\Framework\Facades\Config;
use Maduser\Minimal\Framework\Facades\Event;
use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Facades\Router;
use Maduser\Minimal\Routing\Route;

/**
 * Class RouterCommands
 *
 * @package App
 */
class MinimalCommands extends AbstractCommands
{
    /**
     * @return array
     */
    public static function commands(): array
    {
        return [
            Command::create('/', [self::class, 'index'], [
                'description' => 'Lists all available routes',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('routes', [self::class, 'routesList'], [
                'description' => 'Lists all available routes',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('bindings', [self::class, 'bindingsList'], [
                'description' => 'Lists all registered interface bindings',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('providers', [self::class, 'providersList'], [
                'description' => 'Lists all registered service providers',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('events', [self::class, 'eventsList'], [
                'description' => 'Lists all registered events and subscribers',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('config', [self::class, 'configList'], [
                'description' => 'Lists all configs',
                'arguments' => ['direction', 'file'],
                'options' => [
                    'silent' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),

            Command::create('db:dump', [self::class, 'dbDump'], [
                'description' => 'Lists all configs',
                'arguments' => ['file'],
                'options' => [
                    'optionA' => 'Help for option',
                    'force' => 'Help for option',
                ],
                'middlewares' => [],
            ]),
        ];

    }

    /**
     *
     */
    public function index()
    {
        $this->console->line('Hi from ' . get_class($this), 'red', 'yellow');
    }

    /**
     *
     */
    public function routesList()
    {
        $header = [['Type', 'Pattern', 'Action', 'Middlewares']];
        $data = [];

        $router = Router::getInstance();

        /** @var Collection $routes */
        $routes = $router->getRoutes()->get('ALL');

        foreach ($routes->getArray() as $route) {
            /** @var Route $route */

            $mws = $route->getMiddlewares();

            $str = '';
            foreach ($mws as $key => $mw) {
                $mw = is_array($mw) ? $key . '(' . implode($mw, ', ') . ')' : $mw;
                $str .= !empty($str) ? ', ' . $mw : $mw;
            }

            $data[] = [
                'type' => $route->getRequestMethod(),
                'pattern' => '/' . ltrim($route->getUriPrefix() . $route->getUriPattern(), '/'),
                'action' => $route->hasClosure() ? '<= Closure()' : $route->getController() . '@' . $route->getAction(),
                'middleware' => $str
            ];

        }

        $this->console->table($data, $header);
    }

    /**
     *
     */
    public function bindingsList()
    {
        $thead = [['Alias', 'Binding']];
        $tbody = [];

        $items = IOC::bindings()->getArray();

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

    /**
     *
     */
    public function providersList()
    {
        $thead = [['Alias', 'Provider']];
        $tbody = [];

        $items = IOC::providers()->getArray();

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

    /**
     *
     */
    public function eventsList()
    {
        $thead = [['Events', 'Actions']];
        $tbody = [];

        foreach (Event::events() as $event => $subscribers) {
            $array = [];
            foreach ($subscribers as $subscriber) {
                /** @var $subscriber Subscriber */
                $actions = $subscriber->getEventActions($event);

                foreach ($actions as $action) {
                    $array[] = get_class($subscriber) . '::' . $action;
                }

            }

            $tbody[] = [$event, implode(', ', $array)];
        }

        $this->console->table($tbody, $thead);
    }

    /**
     *
     */
    public function configList()
    {
        $thead = [['Alias', 'Value']];
        $tbody = [];

        $items = $this->array_flat(Config::items());

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

    public function dbDump($file = null)
    {
        $config = Config::database('default');

        is_null($file) ? $file = date('Y-m-d-h-i-s').'-'. $config['database'].'.sql' : $file;

        $file = Config::storage('db-dumps') . '/' . $file;

        $this->console->write(
            exec("mysqldump --user=".$config['username']." --password=". $config['password']." --host=". $config['host']." ".$config['database']." --result-file={$file} 2>&1", $output)
        );

        $this->console->write('Database has been dumped to ' . $file);
    }

    /**
     * @param        $array
     * @param string $prefix
     *
     * @return array
     */
    protected function array_flat($array, $prefix = '')
    {
        $result = array();

        foreach ($array as $key => $value) {
            $new_key = $prefix . (empty($prefix) ? '' : '.') . $key;

            if (is_array($value)) {
                $result = array_merge($result, $this->array_flat($value, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }

        return $result;
    }
}