<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 09.07.19
 * Time: 11:41
 */

namespace Netzexpert\LeaveParcel\Plugin;


use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\ShippingAddressManagement;

class ShippingAddressManagementInterfacePlugin
{

    /**
     * @param ShippingAddressManagement $shippingAddressManagement
     * @param $cartId
     * @param AddressInterface $address
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeAssign(
        ShippingAddressManagement $shippingAddressManagement,
        $cartId,
        AddressInterface $address
    ) {
        $addressExtension = $address->getExtensionAttributes();
        if (!empty($addressExtension)) {
            $address->setData('leave_at', $addressExtension->getLeaveAt());
            $address->setData('comment', $addressExtension->getComment());
        }
        return [$cartId, $address];
    }
}
