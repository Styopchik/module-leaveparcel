/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'underscore',
    'mage/utils/wrapper',
    'mage/translate',
    'Magento_Checkout/js/model/quote'
], function ($, _, wrapper, $t, quote) {
    'use strict';

    return function (setShippingInformationAction) {

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
            if (shippingAddress['extension_attributes'] === undefined) {
                shippingAddress['extension_attributes'] = {};
            }

            if (shippingAddress.customAttributes &&
                !_.isUndefined(shippingAddress.customAttributes.leave_parcel) &&
                (shippingAddress.customAttributes.leave_parcel.value === "1" ||
                    shippingAddress.customAttributes.leave_parcel.value === true)) {
                $.each(shippingAddress.customAttributes, function (index, attribute) {
                    shippingAddress['extension_attributes'][attribute.attribute_code] = attribute.value;
                    switch (attribute.attribute_code) {
                        case 'leave_at':
                            attribute.label = $t('Leave at:');
                            break;
                        case 'comment':
                            attribute.label = $t('Comment:');
                            break;
                        default:
                            break;
                    }
                });
                return originalAction();
            }
            /*shippingAddress.customAttributes = _.filter(shippingAddress.customAttributes, function (attribute) {
                return !_.contains(['leave_parcel', 'leave_at', 'comment'], attribute.attribute_code);
            });*/
            // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
            return originalAction();
        });
    };
});