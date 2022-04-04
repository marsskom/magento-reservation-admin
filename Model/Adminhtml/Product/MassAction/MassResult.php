<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\MassAction;

use Marsskom\ReservationAdmin\Api\Data\Product\MassAction\MassResultInterface;

class MassResult implements MassResultInterface
{
    private int $affectedCount;

    private int $erroredCount;

    /**
     * Mass result constructor.
     *
     * @param int $affectedCount
     * @param int $erroredCount
     */
    public function __construct(
        int $affectedCount = 0,
        int $erroredCount = 0
    ) {
        $this->affectedCount = $affectedCount;
        $this->erroredCount = $erroredCount;
    }

    /**
     * @inheritdoc
     */
    public function getAffectedCount(): int
    {
        return $this->affectedCount;
    }

    /**
     * @inheritdoc
     */
    public function getErroredCount(): int
    {
        return $this->erroredCount;
    }
}
