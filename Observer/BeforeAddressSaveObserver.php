<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 16.07.19
 * Time: 14:31
 */

namespace Netzexpert\LeaveParcel\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BeforeAddressSaveObserver implements ObserverInterface
{
    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        $address = $observer->getData('customer_address');
        if (!$address->getData('leave_parcel')) {
            $address->setData('leave_at', '');
            $address->setData('comment', '');
        }
    }

}
