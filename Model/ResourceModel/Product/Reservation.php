<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reservation extends AbstractDb
{
    public const TABLE_NAME = 'inventory_reservation';

    protected $_idFieldName = 'reservation_id';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, $this->_idFieldName);
    }
}
