<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Controller\Adminhtml\Product;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Marsskom\ReservationAdmin\Api\Data\EventManagerInterface;
use Marsskom\ReservationAdmin\Api\Data\Product\MassAction\MassResultInterface;
use Marsskom\ReservationAdmin\Exception\Event\EventNotFoundException;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Events;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\MassDeleteFactory;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\CollectionFactory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
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

    protected EventManagerInterface $eventManager;

    /**
     * Mass delete constructor.
     *
     * @param Context               $context
     * @param Filter                $filter
     * @param CollectionFactory     $collectionFactory
     * @param MassDeleteFactory     $actionFactory
     * @param EventManagerInterface $eventManager
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        MassDeleteFactory $actionFactory,
        EventManagerInterface $eventManager
    ) {
        parent::__construct($context);

        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     *
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->eventManager->dispatch(Events::BEFORE_MASS_DELETE);

        $result = $this->actionFactory
            ->create()
            ->process(
                $this->filter->getCollection($this->collectionFactory->create())
            );

        $this->addMessages($result);
        $this->dispatchResultEvents($result);

        return $this->resultFactory
            ->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('reservation/product/index');
    }

    /**
     * Adds messages.
     *
     * @param MassResultInterface $result
     *
     * @return void
     */
    protected function addMessages(MassResultInterface $result): void
    {
        if ($result->getAffectedCount() > 0) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $result->getAffectedCount())
            );
        }

        if ($result->getErroredCount()) {
            $this->messageManager->addErrorMessage(
                __(
                    "A total of %1 record(s) haven't been deleted. Please see server logs for more details.",
                    $result->getErroredCount()
                )
            );
        }
    }

    /**
     * Dispatches events.
     *
     * @param MassResultInterface $result
     *
     * @return void
     *
     * @throws EventNotFoundException
     */
    protected function dispatchResultEvents(MassResultInterface $result): void
    {
        $payloadData = [
            'affectedCount' => $result->getAffectedCount(),
            'erroredCount'  => $result->getErroredCount(),
        ];

        if ($result->getAffectedCount() > 0) {
            $this->eventManager->dispatch(
                Events::AFTER_MASS_DELETE,
                $payloadData
            );
        }

        if ($result->getErroredCount()) {
            $this->eventManager->dispatch(
                Events::AFTER_MASS_DELETE,
                $payloadData
            );
        }
    }
}
