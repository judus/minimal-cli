<?php

namespace Maduser\Minimal\Cli;


use Maduser\Minimal\Framework\Minimal;
use Maduser\Minimal\Framework\Module;


class Modules
{
    public function __construct()
    {
        $this->console = new Console();

        $this->all();
    }

    protected function all()
    {
        $modules = \Maduser\Minimal\Framework\Facades\Modules::getModules();

        $array = [];

        foreach ($modules as $module) {
            /** @var Module $module */
            $array[] = [
                'name' => $module->getName(),
                'path' => $module->getBasePath(),
                'config' => $module->getConfigFile(),
                'routes' => $module->getRoutesFile(),
                'providers' => $module->getProvidersFile(),
                'bindings' => $module->getBindingsFile()
            ];

        }

        $this->console->table(
            $array,
            [['Name', 'BasePath', 'Config', 'Routes', 'Providers', 'Bindings']]
        );
    }

}