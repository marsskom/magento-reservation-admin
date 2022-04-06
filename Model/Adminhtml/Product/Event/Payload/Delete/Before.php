<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Payload\Delete;

use Marsskom\ReservationAdmin\Api\Data\Product\Event\Adminhtml\Payload\Delete\BeforePayloadInterface;

class Before implements BeforePayloadInterface
{
    private int $reservationId;

    /**
     * Before payload constructor.
     *
     * @param int $reservationId
     */
    public function __construct(
        int $reservationId
    ) {
        $this->reservationId = $reservationId;
    }

    /**
     * @inheritdoc
     */
    public function getReservationId(): int
    {
        return $this->reservationId;
    }
}
