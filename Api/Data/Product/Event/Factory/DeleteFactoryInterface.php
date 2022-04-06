<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product\Event\Factory;

interface DeleteFactoryInterface
{
    /**
     * Creates delete before event.
     *
     * @param int $reservationId
     *
     * @return mixed
     */
    public function before(int $reservationId);

    /**
     * Creates delete after event.
     *
     * @param int  $reservationId
     * @param bool $status
     *
     * @return mixed
     */
    public function after(int $reservationId, bool $status);
}
