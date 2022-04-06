<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product\Event\Payload\Delete;

interface AfterPayloadInterface
{
    /**
     * Returns reservation id.
     *
     * @return int
     */
    public function getReservationId(): int;

    /**
     * Returns status.
     *
     * @return bool
     */
    public function getStatus(): bool;
}
