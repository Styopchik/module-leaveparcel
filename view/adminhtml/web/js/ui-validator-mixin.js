define([
    "jquery",
    'mage/translate',
    'uiRegistry'
], function ($, $t, Registry) {
    'use strict';

    return function (validator) {
        validator.addRule(
            'required-for-others',
            function (value) {
                if (Registry.get('index=leave_at').value() === $t('Other')) {
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