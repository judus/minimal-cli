<?php

namespace Maduser\Minimal\Cli;

use Maduser\Minimal\Framework\Facades\Event;
use Maduser\Minimal\Framework\Minimal;

class Events
{
    public function __construct()
    {
        $this->console = new Console();

        $this->all();
    }

    protected function all()
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

}
