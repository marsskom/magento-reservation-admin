<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\ReservationAdmin\Api\Data\EventManagerInterface;
use Marsskom\ReservationAdmin\Api\Product\ReservationRepositoryInterface;
use Marsskom\ReservationAdmin\Exception\Event\EventNotFoundException;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;
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

    protected EventManagerInterface $eventManager;

    /**
     * Mass delete constructor.
     *
     * @param Context                        $context
     * @param LoggerInterface                $logger
     * @param ReservationRepositoryInterface $reservRepo
     * @param EventManagerInterface          $eventManager
     */
    public function __construct(
        Context $context,
        LoggerInterface $logger,
        ReservationRepositoryInterface $reservRepo,
        EventManagerInterface $eventManager
    ) {
        parent::__construct($context);

        $this->logger = $logger;
        $this->reservRepo = $reservRepo;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     * @throws EventNotFoundException
     */
    public function execute()
    {
        $reservationId = (int) $this->getRequest()->getParam('id');

        try {
            $this->eventManager->dispatch(Events::BEFORE_DELETE, ['reservationId' => $reservationId,]);

            $this->reservRepo->deleteById($reservationId);

            $this->eventManager->dispatch(
                Events::AFTER_DELETE,
                [
                    'reservationId' => $reservationId,
                    'status'        => true,
                ]
            );

            $this->messageManager->addSuccessMessage(__('The reservation has been deleted.'));
        } catch (LocalizedException $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());
            $this->messageManager->addErrorMessage(__("We can't delete reservation."));

            $this->eventManager->dispatch(
                Events::AFTER_DELETE,
                [
                    'reservationId' => $reservationId,
                    'status'        => false,
                ]
            );
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/');
    }
}
