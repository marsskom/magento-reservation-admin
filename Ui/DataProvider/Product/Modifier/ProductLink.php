<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Ui\DataProvider\Product\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Marsskom\ReservationAdmin\Model\Adminhtml\Product\Modifier\LinkPicker;
use function array_values;
use function sprintf;

class ProductLink implements ModifierInterface
{
    protected LinkPicker $linkPicker;

    /**
     * Product link constructor.
     *
     * @param LinkPicker $linkPicker
     */
    public function __construct(
        LinkPicker $linkPicker
    ) {
        $this->linkPicker = $linkPicker;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        if (empty($data)) {
            return $data;
        }

        // Collect skus.
        $skus = [];
        foreach ($data['items'] as $item) {
            $skus[$item['sku']] = $item['sku'];
        }

        $uris = $this->linkPicker->get(array_values($skus));
        foreach ($data['items'] as &$item) {
            $uri = $uris[$item['sku']] ?? null;
            if (null === $uri) {
                continue;
            }

            $item['sku'] = sprintf(
                '<a href="%s" target="_blank">%s</a>',
                $uri,
                $item['sku']
            );
        }
        unset($item);

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta): array
    {
        return $meta;
    }
}
