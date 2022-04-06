<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete;

use Marsskom\ReservationAdmin\Api\Data\Product\Event\Payload\Delete\AfterPayloadInterface;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event;

class AfterDelete extends Event
{
    /**
     * @inheridoc
     *
     * @return AfterPayloadInterface
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
