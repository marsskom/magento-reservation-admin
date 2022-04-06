<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model;

use Magento\Framework\Event\ManagerInterface;
use Marsskom\ReservationAdmin\Api\Data\EventDispatcherInterface;
use Marsskom\ReservationAdmin\Api\Data\EventInterface;
use Psr\Log\LoggerInterface;
use function sprintf;

class EventDispatcher implements EventDispatcherInterface
{
    private LoggerInterface $logger;

    private ManagerInterface $eventManager;

    /**
     * Event dispatcher constructor.
     *
     * @param LoggerInterface  $logger
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        LoggerInterface $logger,
        ManagerInterface $eventManager
    ) {
        $this->logger = $logger;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     */
    public function dispatch(EventInterface $event): void
    {
        $this->logger->debug(
            sprintf(
                "Before dispatch event %s",
                $event->getName()
            )
        );

        $this->eventManager->dispatch(
            $event->getName(),
            $event->toArray()
        );

        $this->logger->debug(
            sprintf(
                "After dispatched event %s",
                $event->getName()
            )
        );
    }
}
