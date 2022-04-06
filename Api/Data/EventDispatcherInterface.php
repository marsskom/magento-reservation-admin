<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data;

interface EventDispatcherInterface
{
    /**
     * Dispatches event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function dispatch(EventInterface $event): void;
}
