define([
    "jquery",
    'mage/translate'
], function ($, $t) {
    'use strict';

    return function (validator) {
        $.validator.addMethod(
            'required-for-others',
            function (value) {
                if ($("#order-shipping_address_leave_at").val() === $t('Other')) {
                    return !$.mage.isEmpty(value);
                } else {
                    return true;
                }
            },
            $t('This is a required field.')
        );
        return validator;
    };
});