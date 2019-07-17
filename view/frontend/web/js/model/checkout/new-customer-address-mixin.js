define([
    'jquery',
    'mage/utils/wrapper',
    'mage/translate',
], function ($, wrapper, $t) {
    'use strict';

    return function (address) {
        return wrapper.wrap(address, function (originalAddress, addressData) {
            var newAttr = {};
            $.each(addressData.custom_attributes, function (index, attribute) {
                newAttr[attribute.attribute_code] = {
                    'attribute_code': attribute.attribute_code,
                    'value': attribute.value
                };
                switch (attribute.attribute_code) {
                    case 'leave_at':
                        newAttr[attribute.attribute_code].attribute_label = $t('Leave at:');
                        break;
                    case 'comment':
                        newAttr[attribute.attribute_code].attribute_label = $t('Comment:');
                        break;
                    default:
                        break;
                }
            });
            addressData.custom_attributes = newAttr;
            return originalAddress(addressData);
        });
    }
});