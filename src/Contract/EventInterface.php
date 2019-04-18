<?php

namespace Xeviant\Paystack\Contract;

interface EventInterface
{
    public function fire(string $event, array $payload = []);

    public function listen(string $event, callable $listener);
}
