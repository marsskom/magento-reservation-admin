<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Factory\Delete;

use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete\AfterDelete;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Delete\AfterDeleteFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Payload\Delete\AfterFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;

class AfterEventFactory
{
    private AfterDeleteFactory $eventFactory;

    private AfterFactory $payloadFactory;

    /**
     * Event factory constructor.
     *
     * @param AfterDeleteFactory $eventFactory
     * @param AfterFactory       $payloadFactory
     */
    public function __construct(
        AfterDeleteFactory $eventFactory,
        AfterFactory $payloadFactory
    ) {
        $this->eventFactory = $eventFactory;
        $this->payloadFactory = $payloadFactory;
    }

    /**
     * Creates delete event.
     *
     * @param int  $reservationId
     * @param bool $status
     *
     * @return AfterDelete
     */
    public function create(int $reservationId, bool $status): AfterDelete
    {
        return $this->eventFactory->create([
            'name'    => Events::AFTER_DELETE,
            'payload' => $this->payloadFactory->create([
                'reservationId' => $reservationId,
                'status'        => $status,
            ]),
        ]);
    }
}
