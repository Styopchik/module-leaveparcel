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
    });
});
