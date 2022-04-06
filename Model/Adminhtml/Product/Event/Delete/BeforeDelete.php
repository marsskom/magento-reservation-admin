<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete;

use Marsskom\ReservationAdmin\Api\Data\Product\Event\Payload\Delete\BeforePayloadInterface;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event;

class BeforeDelete extends Event
{
    /**
     * @inheridoc
     *
     * @return BeforePayloadInterface
     */
    public function getPayload()
    {
        return $this->payload;
    }
}
