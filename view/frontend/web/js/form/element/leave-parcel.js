define([
    'Magento_Ui/js/form/element/single-checkbox'
], function (AbstractField) {
    'use strict';

    return AbstractField.extend({
        defaults: {
            modules: {
                leaveAt: '${ $.parentName }.leave_at',
                comment: '${ $.parentName }.comment'
            }
        },

        onCheckedChanged: function () {
            this.leaveAt().visible(this.checked());
            this._super()
        }


    });
});
