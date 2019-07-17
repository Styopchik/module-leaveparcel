define([
    "Magento_Ui/js/form/element/select"
], function (Select) {
    'use strict';

    return Select.extend({
        defaults: {
            modules: {
                leaveParcel: '${ $.parentName }.leave_parcel',
            }
        },

        initialize: function () {
            this._super();
            this.refreshComponent();
            this.leaveParcel().on('value', this.refreshComponent.bind(this));
            return this;
        },

        refreshComponent: function () {
            this.visible(this.leaveParcel().value() === "1");
        }
    });
});