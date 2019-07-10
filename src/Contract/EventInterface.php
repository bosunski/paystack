<?php

namespace Xeviant\Paystack\Contract;

interface EventInterface
{
    /**
     * @param string $event
     * @param null   $payload
     *
     * @return mixed
     */
    public function fire(string $event, $payload = null);

    /**
     * @param string   $event
     * @param callable $listener
     *
     * @return mixed
     */
    public function listen(string $event, callable $listener);
}
