<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product;

interface ReservationInterface
{
    /**
     * Sets id.
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function setId($value);

    /**
     * Returns id.
     *
     * @return int|string
     */
    public function getId();

    /**
     * Sets stock id.
     *
     * @param mixed $stockId
     *
     * @return $this
     */
    public function setStockId($stockId): self;

    /**
     * Returns stock id.
     *
     * @return int
     */
    public function getStockId(): int;

    /**
     * Sets sku.
     *
     * @param mixed $sku
     *
     * @return $this
     */
    public function setSku($sku): self;

    /**
     * Returns product data string.
     *
     * @return string
     */
    public function getSku(): string;

    /**
     * Sets quantity.
     *
     * @param mixed $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity): self;

    /**
     * Returns quantity.
     *
     * @return float
     */
    public function getQuantity(): float;

    /**
     * Sets metadata.
     *
     * @param mixed $metadata
     *
     * @return $this
     */
    public function setMetadata($metadata): self;

    /**
     * Returns metadata.
     *
     * @return string
     */
    public function getMetadata(): string;
}
