<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product;

use Marsskom\ReservationAdmin\Api\Data\Product\EventInterface;

abstract class Event implements EventInterface
{
    protected string $name;

    /**
     * Payload interface.
     *
     * @var mixed
     */
    protected $payload;

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
     * @inheridoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheridoc
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @inheridoc
     */
    public function toArray(): array
    {
        return [
            'name'    => $this->getName(),
            'payload' => $this->getPayload(),
        ];
    }
}
