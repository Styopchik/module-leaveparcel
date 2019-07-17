define([
    "jquery",
    "mage/translate"
], function ($, $t) {
    'use strict';

    return function (validation) {

        $.validator.addMethod(
            'required-for-others',
            function (value) {
                if ($("#leave_at").val() === $t('Other')) {
                    return !$.mage.isEmpty(value);
                } else {
                    return true;
                }
            },
            $t('This is a required field.')
        );
        return validation;
    }
});