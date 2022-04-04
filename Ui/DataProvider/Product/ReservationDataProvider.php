<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Ui\DataProvider\Product;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\Collection;

class ReservationDataProvider extends AbstractDataProvider
{
    /**
     * Reservation data provider constructor.
     *
     * @param string     $name
     * @param string     $primaryFieldName
     * @param string     $requestFieldName
     * @param Collection $collection
     * @param array      $meta
     * @param array      $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        Collection $collection,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collection;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
    }

    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->loadCollectionWithFilters();
        }

        return $this->getCollection()->toArray();
    }

    /**
     * Adds filters to collection.
     *
     * @return void
     */
    protected function loadCollectionWithFilters(): void
    {
        $this->getCollection()->load();
    }
}
