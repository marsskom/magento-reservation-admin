<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class ProductActions extends Column
{
    protected UrlInterface $urlBuilder;

    /**
     * Product actions constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface       $urlBuilder
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );

        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @inheridoc
     */
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['delete'] = [
                'href'    => $this->urlBuilder->getUrl(
                    'reservation/product/delete',
                    ['id' => $item['reservation_id']]
                ),
                'confirm' => [
                    'title'   => __('Delete #%1', $item['reservation_id']),
                    'message' => __('Are you sure you want to delete a #%1 record?', $item['reservation_id']),
                ],
                'label'   => __('Delete'),
                'hidden'  => false,
                'post'    => true,
            ];
        }

        return $dataSource;
    }
}
