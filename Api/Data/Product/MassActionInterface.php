<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product;

use Magento\Framework\Data\Collection\AbstractDb;
use Marsskom\ReservationAdmin\Api\Data\Product\MassAction\MassResultInterface;

interface MassActionInterface
{
    /**
     * Processes work on filtered collection items and returns result.
     *
     * @param AbstractDb $abstractDb
     *
     * @return MassResultInterface
     */
    public function process(AbstractDb $abstractDb): MassResultInterface;
}
