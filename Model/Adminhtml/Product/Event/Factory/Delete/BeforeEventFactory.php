<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Factory\Delete;

use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete\BeforeDelete;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete\BeforeDeleteFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Payload\Delete\BeforeFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;

class BeforeEventFactory
{
    private BeforeDeleteFactory $eventFactory;

    private BeforeFactory $payloadFactory;

    /**
     * Event factory constructor.
     *
     * @param BeforeDeleteFactory $eventFactory
     * @param BeforeFactory       $payloadFactory
     */
    public function __construct(
        BeforeDeleteFactory $eventFactory,
        BeforeFactory $payloadFactory
    ) {
        $this->eventFactory = $eventFactory;
        $this->payloadFactory = $payloadFactory;
    }

    /**
     * Creates delete event.
     *
     * @param int $reservationId
     *
     * @return BeforeDelete
     */
    public function create(int $reservationId): BeforeDelete
    {
        return $this->eventFactory->create([
            'name'    => Events::BEFORE_DELETE,
            'payload' => $this->payloadFactory->create([
                'reservationId' => $reservationId,
            ]),
        ]);
    }
}
