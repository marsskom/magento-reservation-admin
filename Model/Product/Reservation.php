<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Product;

use Magento\Framework\Model\AbstractModel;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationInterface;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\Reservation as ResourceModel;

class Reservation extends AbstractModel implements ReservationInterface
{
    protected $_idFieldName = 'reservation_id';

    private int $stockId;

    private string $sku;

    private float $quantity;

    private string $metadata;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function setStockId($stockId): ReservationInterface
    {
        $this->stockId = (int) $stockId;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStockId(): int
    {
        return $this->stockId;
    }

    /**
     * @inheritdoc
     */
    public function setSku($sku): ReservationInterface
    {
        $this->sku = (string) $sku;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @inheritdoc
     */
    public function setQuantity($quantity): ReservationInterface
    {
        $this->quantity = (float) $quantity;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    /**
     * @inheritdoc
     */
    public function setMetadata($metadata): ReservationInterface
    {
        $this->metadata = (string) $metadata;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMetadata(): string
    {
        return $this->metadata;
    }
}
