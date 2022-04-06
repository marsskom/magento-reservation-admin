<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model;

use Marsskom\ReservationAdmin\Api\Data\EventInterface;

class Event implements EventInterface
{
    private string $name;

    /**
     * Payload interface.
     *
     * @var mixed
     */
    private $payload;

    /**
     * Event constructor.
     *
     * @param string $name
     * @param mixed  $payload
     */
    public function __construct(
        string $name,
        $payload
    ) {
        $this->name = $name;
        $this->payload = $payload;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return [
            'name'    => $this->getName(),
            'payload' => $this->getPayload(),
        ];
    }
}
