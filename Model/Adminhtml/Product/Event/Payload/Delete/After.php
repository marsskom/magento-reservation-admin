<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Payload\Delete;

use Marsskom\ReservationAdmin\Api\Data\Product\Event\Adminhtml\Payload\Delete\AfterPayloadInterface;

class After implements AfterPayloadInterface
{
    private int $reservationId;

    private bool $status;

    /**
     * After payload constructor.
     *
     * @param int  $reservationId
     * @param bool $status
     */
    public function __construct(
        int $reservationId,
        bool $status
    ) {
        $this->reservationId = $reservationId;
        $this->status = $status;
    }

    /**
     * @inheritdoc
     */
    public function getReservationId(): int
    {
        return $this->reservationId;
    }

    /**
     * @inheritdoc
     */
    public function getStatus(): bool
    {
        return $this->status;
    }
}
