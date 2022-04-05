define([
    'jquery',
    'Magento_Ui/js/grid/columns/column',
    'mage/translate',
], function ($, Column) {
    'use strict';

    return Column.extend({
        defaults: {
            headerTmpl: 'Marsskom_ReservationAdmin/grid/product/columns/metadata',
            bodyTmpl: 'Marsskom_ReservationAdmin/grid/product/cells/metadata',
        },

        /**
         * Returns metadata as pretty json.
         *
         * @param row
         * @param elem
         */
        setJson: function (row, elem) {
            if (!('metadata' in row)) {
                return;
            }

            let pre = document.createElement("pre");
            pre.className = 'metadata-pre';
            pre.innerHTML = this.syntaxHighlight(
                JSON.parse(row.metadata)
            );

            elem.append(pre);
        },

        /**
         * Adds tags for syntax highlight.
         *
         * @param json
         * @returns {string}
         */
        syntaxHighlight: function (json) {
            if (typeof json !== 'string') {
                json = JSON.stringify(json, null, 4);
            }

            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                let cls = 'number';

                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }

                return '<span class="' + cls + '">' + match + '</span>';
            });
        },

        /**
         * Toggles metadata view.
         *
         * @param row
         * @param event
         */
        toggleView: function (row, event) {
            let self = $(event.currentTarget);
            let prettyContainer = self.parent().find('.pretty-container');
            let rawContainer = self.parent().find('.raw-container');

            if (prettyContainer.html() === '') {
                this.setJson(row, prettyContainer);
            }

            if (prettyContainer.is(':visible')) {
                prettyContainer.hide();
                rawContainer.show();

                self.text($.mage.__('Show pretty'));
            } else {
                rawContainer.hide();
                prettyContainer.show();

                self.text($.mage.__('Show raw'));
            }
        },
    });
});
