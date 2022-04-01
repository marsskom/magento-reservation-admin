<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\InventoryApi\Api\StockRepositoryInterface;

class Stock implements OptionSourceInterface
{
    protected StockRepositoryInterface $stockRepository;

    /**
     * Stock model constructor.
     *
     * @param StockRepositoryInterface $stockRepository
     */
    public function __construct(
        StockRepositoryInterface $stockRepository
    ) {
        $this->stockRepository = $stockRepository;
    }

    /**
     * @inheritdoc
     */
    public function toOptionArray(): array
    {
        $result = [];
        foreach ($this->stockRepository->getList()->getItems() as $stock) {
            $result[] = [
                'label' => $stock->getName(),
                'value' => $stock->getStockId(),
            ];
        }

        return $result;
    }
}
