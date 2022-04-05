define([
    'Magento_Ui/js/grid/columns/column',
], function (Column) {
    'use strict';

    return Column.extend({
        defaults: {
            bodyTmpl: 'Marsskom_ReservationAdmin/grid/product/cells/quantity'
        },

        /**
         * Returns quantity color class.
         *
         * @param row
         * @returns {string}
         */
        getColor: function (row) {
            if (!('quantity' in row)) {
                return 'qty-column-default';
            }

            if (row.quantity > 0) {
                return 'qty-column-green';
            }

            if (row.quantity < 0) {
                return 'qty-column-red';
            }

            return 'qty-column-default';
        },
    });
});
