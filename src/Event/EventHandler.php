<?php

namespace Xeviant\Paystack\Event;


use League\Event\Emitter;
use Xeviant\Paystack\Contract\EventInterface;

class EventHandler extends Emitter implements EventInterface
{
    public function fire($event)
    {
        return $this->emit($event);
    }

    public function listen($event, $listener)
    {
        return $this->addListener($event, $listener);
    }
}
