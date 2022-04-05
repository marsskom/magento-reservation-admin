<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Product;

use Magento\Framework\Api\SearchResults;
use Marsskom\ReservationAdmin\Api\Data\Product\ReservationSearchResultInterface;

class ReservationSearchResult extends SearchResults implements ReservationSearchResultInterface
{
}
