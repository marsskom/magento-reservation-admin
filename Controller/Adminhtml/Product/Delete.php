<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\ReservationAdmin\Api\Product\ReservationRepositoryInterface;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\EventsFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\MassDeleteFactory;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\CollectionFactory;
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

    protected EventsFactory $eventsFactory;

    /**
     * Mass delete constructor.
     *
     * @param Context                        $context
     * @param LoggerInterface                $logger
     * @param ReservationRepositoryInterface $reservRepo
     * @param EventsFactory                  $eventsFactory
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ReservationRepositoryInterface $reservRepo,
        EventsFactory $eventsFactory
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
        $reservationId = $this->getRequest()->getParam('id');

        try {
            $event = $this->eventsFactory->create(Events::BEFORE_DELETE, $reservationId, true);
            $this->_eventManager->dispatch($event->getName(), $event->toArray());

            $this->reservRepo->deleteById($reservationId);

            $event = $this->eventsFactory->create(Events::AFTER_DELETE, $reservationId, true);
            $this->_eventManager->dispatch($event->getName(), $event->toArray());

            $this->messageManager->addSuccessMessage(__('The reservation has been deleted.'));
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());

            $event = $this->eventsFactory->create(Events::AFTER_DELETE, $reservationId, false);
            $this->_eventManager->dispatch($event->getName(), $event->toArray());

            $this->messageManager->addErrorMessage(__("We can't delete reservation."));
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }
}
