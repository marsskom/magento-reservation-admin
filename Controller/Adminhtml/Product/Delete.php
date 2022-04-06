<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\ReservationAdmin\Api\Data\Product\EventInterface;
use Marsskom\ReservationAdmin\Api\Product\ReservationRepositoryInterface;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Event\Factory\Delete\EventFactory;
use Psr\Log\LoggerInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Marsskom_ReservationAdmin::reservation_delete';

    protected LoggerInterface $logger;

    protected ReservationRepositoryInterface $reservRepo;

    protected EventFactory $eventsFactory;

    /**
     * Mass delete constructor.
     *
     * @param Context                        $context
     * @param LoggerInterface                $logger
     * @param ReservationRepositoryInterface $reservRepo
     * @param EventFactory                   $eventsFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ReservationRepositoryInterface $reservRepo,
        EventFactory $eventsFactory
    ) {
        parent::__construct($context);

        $this->logger = $logger;
        $this->reservRepo = $reservRepo;
        $this->eventsFactory = $eventsFactory;
    }

    /**
     * @inheridoc
     */
    public function execute()
    {
        $reservationId = (int) $this->getRequest()->getParam('id');

        try {
            $this->dispatchEvent($this->eventsFactory->before($reservationId));

            $this->reservRepo->deleteById($reservationId);

            $this->dispatchEvent($this->eventsFactory->after($reservationId, true));

            $this->messageManager->addSuccessMessage(__('The reservation has been deleted.'));
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());
            $this->messageManager->addErrorMessage(__("We can't delete reservation."));

            $this->dispatchEvent($this->eventsFactory->after($reservationId, false));
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }

    /**
     * Dispatches event.
     *
     * @param EventInterface $event
     *
     * @return void
     */
    protected function dispatchEvent(EventInterface $event): void
    {
        $this->_eventManager->dispatch(
            $event->getName(),
            $event->toArray()
        );
    }
}
