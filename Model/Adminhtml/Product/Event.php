<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product;

use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Payload;

class Event
{
    private string $name;

    private Payload $payload;

    /**
     * Event constructor.
     *
     * @param string  $name
     * @param Payload $payload
     */
    public function __construct(
        string $name,
        Payload $payload
    ) {
        $this->name = $name;
        $this->payload = $payload;
    }

    /**
     * Returns event name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns event payload.
     *
     * @return Payload
     */
    public function getPayload(): Payload
    {
        return $this->payload;
    }

    /**
     * Returns event data as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'eventName' => $this->getName(),
            'payload'   => $this->getPayload(),
        ];
    }
}
