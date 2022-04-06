<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product\Event\Adminhtml\Payload\Delete;

interface BeforePayloadInterface
{
    /**
     * Returns reservation id.
     * 
     * @return int
     */
    public function getReservationId(): int;
}
