<?php

namespace Xeviant\Paystack\Event;

use stdClass;

class EventPayload
{
    /**
     * @var string
     */
    private $eventType;

    /**
     * @var mixed
     */
    private $payload;

    public function __construct(string $eventType, $payload)
    {
        $this->eventType = $eventType;
        $this->payload = $payload;
    }

    public function __toString(): string
    {
        return json_encode(['event' => $this->getEventName(), 'data' => $this->getPayload()]);
    }

    public function getPayload(): stdClass
    {
        return is_array($this->payload) ? (object) $this->payload : $this->payload;
    }

    public function getEventName(): string
    {
        return $this->eventType;
    }
}
