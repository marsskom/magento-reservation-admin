<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\ResourceModel\Product;

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
}
