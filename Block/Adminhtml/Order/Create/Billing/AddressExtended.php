<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 11.07.19
 * Time: 12:38
 */

namespace Netzexpert\LeaveParcel\Block\Adminhtml\Order\Create\Billing;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Sales\Block\Adminhtml\Order\Create\Billing\Address;

class AddressExtended extends Address
{
    /**
     * @inheritDoc
     */
    protected function _addAdditionalFormElementData(AbstractElement $element)
    {
        parent::_addAdditionalFormElementData($element);
        if (in_array($element->getId(),['leave_parcel','leave_at','comment'])) {
            $element->setNoDisplay(true);
        }
        return $this;
    }
}
