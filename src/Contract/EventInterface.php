<?php

namespace Xeviant\Paystack\Contract;

interface EventInterface
{
    public function fire($event);

    public function listen($event, $listener);
}
