define([
    "underscore",
    "jquery",
    "mage/translate"
], function (_, $, $t) {
    'use strict';

    return function (defaultRenderer) {
        return defaultRenderer.extend({
            initConfig: function () {
                this._super();
                if (!_.isUndefined(this.address().customAttributes) &&
                    !_.isUndefined(this.address().customAttributes.leave_parcel) &&
                    this.address().customAttributes.leave_parcel.value === "1") {
                    $.each(this.address().customAttributes, function (index, attribute) {
                        switch (attribute.attribute_code) {
                            case "leave_at":
                                attribute.attribute_label = $t('Leave at:');
                                break;
                            case "comment":
                                attribute.attribute_label = $t('Comment:');
                        }
                    });
                    this.template = 'Netzexpert_LeaveParcel/shipping-address/address-renderer/leave-parcel';
                }
                return this;
            }
        });
    }
});