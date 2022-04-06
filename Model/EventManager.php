<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model;

use Marsskom\ReservationAdmin\Api\Data\EventDispatcherInterface;
use Marsskom\ReservationAdmin\Api\Data\EventInterface;
use Marsskom\ReservationAdmin\Api\Data\EventInterfaceFactory;
use Marsskom\ReservationAdmin\Api\Data\EventManagerInterface;
use Marsskom\ReservationAdmin\Exception\Event\EventNotFoundException;

class EventManager implements EventManagerInterface
{
    private EventDispatcherInterface $eventDispatcher;

    private EventInterfaceFactory $eventFactory;

    private array $events;

    /**
     * Delete controller manager constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param EventInterfaceFactory    $eventFactory
     * @param array                    $events
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        EventInterfaceFactory $eventFactory,
        array $events = []
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventFactory = $eventFactory;
        $this->events = $events;
    }

    /**
     * @ingeritdoc
     */
    public function dispatch(string $eventName, array $payloadData = []): EventInterface
    {
        if (!isset($this->events[$eventName])) {
            throw new EventNotFoundException(__("'%1' event not found", $eventName));
        }

        $payloadFactory = $this->events[$eventName];
        $payload = $payloadFactory->create($payloadData);

        $event = $this->eventFactory->create([
            'name'    => $eventName,
            'payload' => $payload,
        ]);

        $this->eventDispatcher->dispatch($event);

        return $event;
    }
}
