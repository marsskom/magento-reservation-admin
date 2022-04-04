<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product\MassAction;

interface MassResultInterface
{
    /**
     * Returns affected rows count.
     *
     * @return int
     */
    public function getAffectedCount(): int;

    /**
     * Returns errored rows count.
     *
     * @return int
     */
    public function getErroredCount(): int;
}
