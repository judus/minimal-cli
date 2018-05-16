<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Framework\Facades\IOC;
use Maduser\Minimal\Framework\Minimal;

class Providers
{
    public function __construct()
    {
        $this->console = new Console();

        $this->all();
    }

    protected function all()
    {
        $thead = [['Alias', 'Provider']];
        $tbody = [];

        $items = IOC::providers()->getArray();

        foreach ($items as $key => $value) {
            $tbody[] = [$key, $value];
        }

        $this->console->table($tbody, $thead);
    }

}