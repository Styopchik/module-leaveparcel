<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 17.07.19
 * Time: 13:21
 */

namespace Netzexpert\LeaveParcel\Plugin\Sales;

use Magento\Sales\Api\Data\OrderAddressExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order\Address;

class OrderPlugin
{
    /** @var OrderAddressExtensionFactory  */
    private $extensionFactory;

    public function __construct(
        OrderAddressExtensionFactory $extensionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param OrderInterface $order
     * @param Address | null $address
     * @return Address | null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetShippingAddress(
        OrderInterface $order,
        $address
    ) {
        if (!$address) {
            return $address;
        }
        if ($address->getData('leave_at') || $address->getData('comment')) {
            $extensionAttributes = $address->getExtensionAttributes();
            if ($extensionAttributes === null) {
                $extensionAttributes = $this->extensionFactory->create();
            }
            $extensionAttributes->setLeaveAt($address->getData('leave_at'))
                ->setComment($address->getData('comment'));
        }
        return $address;
    }
}
