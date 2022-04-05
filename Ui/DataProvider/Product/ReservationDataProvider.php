<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Ui\DataProvider\Product;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Marsskom\ReservationAdmin\Model\ResourceModel\Product\Collection;

class ReservationDataProvider extends AbstractDataProvider
{
    protected RequestInterface $request;

    protected ManagerInterface $messageManager;

    protected ?PoolInterface $modifiersPool;

    /**
     * Reservation data provider constructor.
     *
     * @param string             $name
     * @param string             $primaryFieldName
     * @param string             $requestFieldName
     * @param RequestInterface   $request
     * @param ManagerInterface   $messageManager
     * @param Collection         $collection
     * @param array              $meta
     * @param array              $data
     * @param null|PoolInterface $modifiersPool
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        RequestInterface $request,
        ManagerInterface $messageManager,
        Collection $collection,
        array $meta = [],
        array $data = [],
        PoolInterface $modifiersPool = null
    ) {
        // Collection must be set before parent constructor because it is parent property.
        $this->collection = $collection;

        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );

        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->modifiersPool = $modifiersPool;
    }

    /**
     * @inheritdoc
     *
     * @throws LocalizedException
     */
    public function getData(): array
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->loadCollectionWithFilters();
        }

        return $this->modifyData($this->getCollection()->toArray());
    }

    /**
     * @inheritdoc
     *
     * @throws LocalizedException
     */
    public function getMeta(): array
    {
        return $this->modifyMeta(parent::getMeta());
    }

    /**
     * Adds filters to collection.
     *
     * @return void
     */
    protected function loadCollectionWithFilters(): void
    {
        $this->setPairsOrder();

        $this->getCollection()->load();
    }

    /**
     * Sets pairs order.
     *
     * @return void
     */
    protected function setPairsOrder(): void
    {
        $params = $this->request->getParams();

        $collection = $this->getCollection();
        /** @var $collection Collection */

        if (!$collection->setPairsOrder($params)) {
            $this->messageManager->addNoticeMessage(__("Metadata sorting works with filter by metadata field only."));
        }
    }

    /**
     * Modifies data.
     *
     * @param array $data
     *
     * @return array
     * @throws LocalizedException
     */
    public function modifyData(array $data): array
    {
        if (null === $this->modifiersPool) {
            return $data;
        }

        $result = $data;
        foreach ($this->modifiersPool->getModifiersInstances() as $modifier) {
            $result = $modifier->modifyData($result);
        }

        return $result;
    }

    /**
     * Modifies meta.
     *
     * @param array $data
     *
     * @return array
     * @throws LocalizedException
     */
    public function modifyMeta(array $data): array
    {
        if (null === $this->modifiersPool) {
            return $data;
        }

        $result = $data;
        foreach ($this->modifiersPool->getModifiersInstances() as $modifier) {
            $result = $modifier->modifyMeta($result);
        }

        return $result;
    }
}
