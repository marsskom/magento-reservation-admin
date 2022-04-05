<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product\Modifier;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;

class LinkPicker
{
    protected ProductRepositoryInterface $productRepository;

    protected SearchCriteriaBuilder $criteriaBuilder;

    protected UrlInterface $urlBuilder;

    /**
     * Link picker constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder      $criteriaBuilder
     * @param UrlInterface               $urlBuilder
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        UrlInterface $urlBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Collects and return url to products by their skus.
     *
     * @param array $skus
     *
     * @return array<string, string>
     */
    public function get(array $skus): array
    {
        if (empty($skus)) {
            return [];
        }

        $result = [];
        foreach ($this->getItems($skus) as $item) {
            $result[$item->getSku()] = $this->createUri((int) $item->getId());
        }

        return $result;
    }

    /**
     * Returns product items.
     *
     * @param array $skus
     *
     * @return ProductInterface[]
     */
    protected function getItems(array $skus): array
    {
        return $this->productRepository
            ->getList(
                $this->criteriaBuilder
                    ->addFilter(
                        'sku',
                        $skus,
                        'in'
                    )
                    ->create()
            )
            ->getItems();
    }

    /**
     * Creates uri to product.
     *
     * @param int $productId
     *
     * @return string
     */
    protected function createUri(int $productId): string
    {
        return $this->urlBuilder->getUrl(
            'catalog/product/edit/id',
            ['id' => $productId]
        );
    }
}
