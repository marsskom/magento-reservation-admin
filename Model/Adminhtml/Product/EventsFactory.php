<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product;

use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\PayloadFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\EventFactory;

class EventsFactory
{
    private EventFactory $eventFactory;

    private PayloadFactory $payloadFactory;

    /**
     * Events factory constructor.
     *
     * @param EventFactory   $eventFactory
     * @param PayloadFactory $payloadFactory
     */
    public function __construct(
        EventFactory $eventFactory,
        PayloadFactory $payloadFactory
    ) {
        $this->eventFactory = $eventFactory;
        $this->payloadFactory = $payloadFactory;
    }

    /**
     * Creates event.
     *
     * @param string $eventName
     * @param int    $reservationId
     * @param bool   $status
     *
     * @return Event
     */
    public function create(
        string $eventName,
        int $reservationId,
        bool $status
    ): Event {
        return $this->eventFactory->create([
            'name'    => $eventName,
            'payload' => $this->payloadFactory->create([
                'reservationId' => $reservationId,
                'status'        => $status,
            ]),
        ]);
    }
}
