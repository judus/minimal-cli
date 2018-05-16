<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Minimal;

class Bindings
{
    public function __construct()
    {
        $this->console = new Console();

        $this->all();
    }

    protected function all()
    {
        $thead = [['Alias', 'Binding']];
        $tbody = [];

        $items = IOC::bindings()->getArray();

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

}
