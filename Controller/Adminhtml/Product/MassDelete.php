<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\EventsFactory;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\MassDeleteFactory;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Marsskom_ReservationAdmin::reservation_delete';

    protected Filter $filter;

    protected CollectionFactory $collectionFactory;

    protected MassDeleteFactory $actionFactory;

    protected EventsFactory $eventsFactory;

    /**
     * Mass delete constructor.
     *
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     * @param MassDeleteFactory $actionFactory
     * @param EventsFactory     $eventsFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        MassDeleteFactory $actionFactory,
        EventsFactory $eventsFactory
    ) {
        parent::__construct($context);

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->actionFactory = $actionFactory;
        $this->eventsFactory = $eventsFactory;
    }

    /**
     * @inheridoc
     *
     * @throws LocalizedException
     */
    public function execute()
    {
        $action = $this->actionFactory->create();

        $event = $this->eventsFactory->create(Events::BEFORE_MASS_DELETE, 0, true);
        $this->_eventManager->dispatch($event->getName(), $event->toArray());

        $result = $action->process(
            $this->filter->getCollection($this->collectionFactory->create())
        );

        if ($result->getAffectedCount() > 0) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $result->getAffectedCount())
            );

            $event = $this->eventsFactory->create(Events::AFTER_MASS_DELETE, 0, true);
            $this->_eventManager->dispatch($event->getName(), $event->toArray());
        }

        if ($result->getErroredCount()) {
            $this->messageManager->addErrorMessage(
                __(
                    "A total of %1 record(s) haven't been deleted. Please see server logs for more details.",
                    $result->getErroredCount()
                )
            );

            $event = $this->eventsFactory->create(Events::AFTER_MASS_DELETE, 0, false);
            $this->_eventManager->dispatch($event->getName(), $event->toArray());
        }

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('reservation/product/index');
    }
}
