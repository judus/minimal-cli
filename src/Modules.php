<?php

namespace Maduser\Minimal\Cli;


use Maduser\Minimal\Framework\Minimal;
use Maduser\Minimal\Framework\Module;


class Modules
{
    /**
     * @var Minimal
     */
    private $minimal;

    public function __construct($minimal)
    {
        $this->console = new Console();

        /** @var Minimal minimal */
        $this->minimal = $minimal;

        $this->all();
    }

    protected function all()
    {
        $modules = $this->minimal->getModules()->all();

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