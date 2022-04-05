<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Api\Data\Product;

use Magento\Framework\Api\SearchResultsInterface;

interface ReservationSearchResultInterface extends SearchResultsInterface
{
    /**
     * Returns reservation items.
     *
     * @return ReservationInterface[]
     */
    public function getItems();

    /**
     * Set attributes list.
     *
     * @param ReservationInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);
}
