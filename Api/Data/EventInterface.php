<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data;

interface EventInterface
{
    /**
     * Returns event name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns payload.
     *
     * @return mixed
     */
    public function getPayload();

    /**
     * Converts and returns event data for dispatcher as array.
     *
     * @return array{name:string, payload:mixed}
     */
    public function toArray(): array;
}
