define([
    "Magento_Ui/js/form/element/textarea",
    "mage/translate"
], function (Textarea, $t) {
    'use strict';

    return Textarea.extend({
        defaults: {
            modules: {
                leaveParcel: '${ $.parentName }.leave_parcel',
                leaveAt: '${ $.parentName }.leave_at'
            }
        },

        initialize: function () {
            this._super();
            this.refreshComponent();
            this.leaveParcel().on('value', this.refreshComponent.bind(this));
            this.leaveAt().on('value', this.refreshComponent.bind(this));
            return this;
        },

        refreshComponent: function () {
            this.visible(this.leaveParcel().value() === "1");
            this.additionalClasses._required(this.leaveAt().value() === $t('Other'));
        }
    });
});