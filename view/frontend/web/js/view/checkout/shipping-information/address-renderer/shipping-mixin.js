define([
    'underscore',
    'Magento_Checkout/js/model/quote'
], function (_, quote) {
    'use strict';

    return function (originalShipping) {
        return originalShipping.extend({
            getTemplate: function () {
                if (_.find(quote.shippingAddress().customAttributes, {attribute_code: 'leave_parcel', value: true}) ||
                    _.find(quote.shippingAddress().customAttributes, {attribute_code: 'leave_parcel', value: "1"}) ) {
                    return 'Netzexpert_LeaveParcel/shipping-information/address-renderer/leave-parcel'
                }
                return this._super();
            }
        });
    }
});