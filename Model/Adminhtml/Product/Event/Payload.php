<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event;

class Payload
{
    private int $reservationId;

    private bool $status;

    /**
     * Payload constructor.
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
     * Returns reservation id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->reservationId;
    }

    /**
     * Returns event status.
     *
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }
}
