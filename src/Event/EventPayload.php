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
     * @var array
     */
    private $payload;

    public function __construct(string $eventType, array $payload = [])
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
        return (object) $this->payload;
    }

    public function getEventName(): string
    {
        return $this->eventType;
    }
}
