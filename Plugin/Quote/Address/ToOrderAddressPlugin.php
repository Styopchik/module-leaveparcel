<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 16.07.19
 * Time: 7:50
 */

namespace Netzexpert\LeaveParcel\Plugin\Quote\Address;

use Magento\Quote\Model\Quote\Address;
use Magento\Quote\Model\Quote\Address\ToOrderAddress;
use Magento\Sales\Api\Data\OrderAddressInterface;

class ToOrderAddressPlugin
{

    /**
     * @param ToOrderAddress $subject
     * @param OrderAddressInterface $orderAddress
     * @param Address $address
     * @return OrderAddressInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterConvert(
        ToOrderAddress $subject,
        OrderAddressInterface $orderAddress,
        Address $quoteAddress
    ) {
        if ($quoteAddress->getAddressType() !== Address::ADDRESS_TYPE_SHIPPING) {
            // no need to handle billing addresses
            return $orderAddress;
        }
        $orderAddress->setData('leave_at', $quoteAddress->getData('leave_at'));
        $orderAddress->setData('comment', $quoteAddress->getData('comment'));
        return $orderAddress;
    }
}
