<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\ReservationAdmin\Api\Data\Product\MassAction\MassResultInterface;
use Marsskom\ReservationAdmin\Api\Data\Product\MassAction\MassResultInterfaceFactory;
use Marsskom\ReservationAdmin\Api\Data\Product\MassActionInterface;
use Marsskom\ReservationAdmin\Api\Product\ReservationRepositoryInterface;
use Psr\Log\LoggerInterface;

class MassDelete implements MassActionInterface
{
    protected LoggerInterface $logger;

    protected ReservationRepositoryInterface $reservRepo;

    protected MassResultInterfaceFactory $massResultFactory;

    /**
     * Mass delete constructor.
     *
     * @param LoggerInterface                $logger
     * @param ReservationRepositoryInterface $reservRepo
     * @param MassResultInterfaceFactory     $massResultFactory
     */
    public function __construct(
        LoggerInterface $logger,
        ReservationRepositoryInterface $reservRepo,
        MassResultInterfaceFactory $massResultFactory
    ) {
        $this->logger = $logger;
        $this->reservRepo = $reservRepo;
        $this->massResultFactory = $massResultFactory;
    }

    /**
     * @inheritdoc
     */
    public function process(AbstractDb $abstractDb): MassResultInterface
    {
        $deleted = 0;
        $errored = 0;

        foreach ($abstractDb->getItems() as $item) {
            try {
                $this->reservRepo->delete($item);

                ++$deleted;
            } catch (LocalizedException $exception) {
                $this->logger->error($exception->getMessage(), $exception->getTrace());

                ++$errored;
            }
        }

        return $this->massResultFactory->create([
            'affectedCount' => $deleted,
            'erroredCount'  => $errored,
        ]);
    }
}
