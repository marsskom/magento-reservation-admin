<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Factory\Delete;

use Marsskom\ReservationAdmin\Api\Data\Product\Event\Factory\DeleteFactoryInterface;

class EventFactory implements DeleteFactoryInterface
{
    private BeforeEventFactory $beforeEventFactory;

    private AfterEventFactory $afterEventFactory;

    /**
     * Event factory constructor.
     *
     * @param BeforeEventFactory $beforeEventFactory
     * @param AfterEventFactory  $afterEventFactory
     */
    public function __construct(
        BeforeEventFactory $beforeEventFactory,
        AfterEventFactory $afterEventFactory
    ) {
        $this->beforeEventFactory = $beforeEventFactory;
        $this->afterEventFactory = $afterEventFactory;
    }

    /**
     * @inheridoc
     */
    public function before(int $reservationId)
    {
        return $this->beforeEventFactory->create($reservationId);
    }

    /**
     * @inheridoc
     */
    public function after(int $reservationId, bool $status)
    {
        return $this->afterEventFactory->create($reservationId, $status);
    }
}
