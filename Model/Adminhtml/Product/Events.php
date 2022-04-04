<?php

declare(strict_types = 1);

namespace Marsskom\ReservationAdmin\Model\Adminhtml\Product;

class Events
{
    public const BEFORE_DELETE = 'adminhtml_reservation_product_before_delete';

    public const AFTER_DELETE = 'adminhtml_reservation_product_after_delete';

    public const BEFORE_MASS_DELETE = 'adminhtml_reservation_product_before_mass_delete';

    public const AFTER_MASS_DELETE = 'adminhtml_reservation_product_after_mass_delete';
}
