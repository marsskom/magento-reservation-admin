<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\ResourceModel\Product;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Marsskom\ReservationAdmin\Model\Product\Reservation as Model;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\Reservation as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }

    /**
     * Sets pairs order.
     *
     * @param array $queryParams
     *
     * @return bool
     */
    public function setPairsOrder(array $queryParams): bool
    {
        if ('metadata' !== ($queryParams['sorting']['field'] ?? '')) {
            return true;
        }

        $this->cleanCurrentOrder();

        if (empty($queryParams['filters']['metadata'])) {
            $this->addOrder('reservation_id', SortOrder::DIRECTION);

            return false;
        }

        $this->addOrder('sku', SortOrder::DIRECTION);

        return true;
    }

    /**
     * Cleans default order.
     *
     * @return void
     */
    protected function cleanCurrentOrder(): void
    {
        $this->_orders = [];
    }
}
