<?php

namespace Xeviant\Paystack\Event;


use League\Event\Emitter;
use Xeviant\Paystack\Contract\EventInterface;

class EventHandler extends Emitter implements EventInterface
{
    /**
     * Fires an Event
     *
     * @param string $event
     * @param array $payload
     * @return \League\Event\EventInterface|mixed|string
     */
    public function fire(string $event, array $payload = [])
    {
        return $this->emit($event, $this->getEventPayload($event, $payload));
    }

    /**
     * Listens to an Event
     *
     * @param string $event
     * @param callable $listener
     * @return EventHandler
     */
    public function listen(string $event, callable $listener)
    {
        return $this->addListener($event, $listener);
    }

    /**
     * Creates a consumable Event Payload
     *
     * @param string $evenType
     * @param array $payload
     * @return EventPayload
     */
    protected function getEventPayload(string $evenType, array $payload = []): EventPayload
    {
        return new EventPayload($evenType, $payload);
    }
}
