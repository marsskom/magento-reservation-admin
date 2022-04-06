<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data;

use Marsskom\ReservationAdmin\Exception\Event\EventNotFoundException;

interface EventManagerInterface
{
    /**
     * Creates event and dispatches it.
     *
     * @param string $eventName
     * @param array  $payloadData
     *
     * @return EventInterface
     *
     * @throws EventNotFoundException
     */
    public function dispatch(
        string $eventName,
        array $payloadData = []
    ): EventInterface;
}
