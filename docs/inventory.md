# Inventory Reservation

[How It Works](https://devdocs.magento.com/guides/v2.4/inventory/reservations.html)

Let's start from observer `vendor/magento/module-inventory-source-deduction-api/Model/SourceDeductionService.php` that is responsible on reservation cancellation. You can find this here `vendor/magento/module-inventory-shipping/etc/events.xml`:

```xml
...
<event name="sales_order_shipment_save_after">
    <observer name="inventory_sales_source_deduction_processor" instance="Magento\InventoryShipping\Observer\SourceDeductionProcessor"/>
</event>
...
```

Strange thing, but the service not use the backorders for products:

```php
foreach ($sourceDeductionRequest->getItems() as $item) {
    $itemSku = $item->getSku();
    $qty = $item->getQty();
    $stockItemConfiguration = $this->getStockItemConfiguration->execute(
        $itemSku,
        $stockId
    );

    if (!$stockItemConfiguration->isManageStock()) {
        //We don't need to Manage Stock
        continue;
    }

    $sourceItem = $this->getSourceItemBySourceCodeAndSku->execute($sourceCode, $itemSku);
    if (($sourceItem->getQuantity() - $qty) >= 0) {
        $sourceItem->setQuantity($sourceItem->getQuantity() - $qty);
        $stockStatus = $this->getSourceStockStatus(
            $stockItemConfiguration,
            $sourceItem
        );
        $sourceItem->setStatus($stockStatus);
        $sourceItems[] = $sourceItem;
    } else {
        throw new LocalizedException(
            __('Not all of your products are available in the requested quantity.')
        );
    }
}
```

Of course, we manage the products stock, each product. But the line:

```php
if (($sourceItem->getQuantity() - $qty) >= 0) {
```

doesn't care about backorders, that mean you can create shipment only if the product's quantity is above the zero and is bigger than quantity in the order.

It's look good, but not in the situations when you manage stock dynamically, especially when the stock source is provided by another system.

But you cannot disable this service, the inventory reservation is related to it.

In the case when you disabled it, you will get many negative values for each product in the `inventory_reservation` table without positive values that cancel the reservation:

| reservation_id | stock_id | sku     | quantity | metadata                                                                                                               |
|----------------|----------|---------|----------|------------------------------------------------------------------------------------------------------------------------|
| 3              | 1        | 24-MB01 | -1.0000  | "{""event_type"":""order_placed"",""object_type"":""order"",""object_id"":"""",""object_increment_id"":""000000003""}" |
| 4              | 1        | 24-MB03 | -1.0000  | "{""event_type"":""order_placed"",""object_type"":""order"",""object_id"":"""",""object_increment_id"":""000000003""}" |
| 5              | 1        | 24-MB04 | -1.0000  | "{""event_type"":""order_placed"",""object_type"":""order"",""object_id"":"""",""object_increment_id"":""000000003""}" |

This will make it impossible to buy the products.

In that case you are free to manage the inventory reservation by hand or code override.

Many complaints about how the inventory works you can find in the GitHub issues.
