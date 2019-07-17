var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Netzexpert_LeaveParcel/js/model/checkout/set-shipping-information-mixin': true
            },
            "Magento_Checkout/js/view/shipping-address/address-renderer/default": {
                "Netzexpert_LeaveParcel/js/view/checkout/shipping-address/address-renderer/default-mixin": true
            },
            'Temando_Shipping/js/view/checkout/shipping-information/address-renderer/shipping': {
                'Netzexpert_LeaveParcel/js/view/checkout/shipping-information/address-renderer/shipping-mixin': true
            },
            'Magento_Checkout/js/model/new-customer-address': {
                'Netzexpert_LeaveParcel/js/model/checkout/new-customer-address-mixin': true
            },
            'mage/validation': {
                'Netzexpert_LeaveParcel/js/validation-mixin': true
            }
        }
    }
};