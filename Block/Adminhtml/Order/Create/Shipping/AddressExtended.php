<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 11.07.19
 * Time: 12:38
 */

namespace Netzexpert\LeaveParcel\Block\Adminhtml\Order\Create\Shipping;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Element\Template;
use Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Address;

class AddressExtended extends Address
{
    /**
     * @inheritDoc
     */
    protected function _addAdditionalFormElementData(AbstractElement $element)
    {
        parent::_addAdditionalFormElementData($element);
        if ($element->getId() == 'leave_at') {
            $block = $this->getLayout()->createBlock(Template::class)
                ->setTemplate('Netzexpert_LeaveParcel::parcel-script.phtml')->toHtml();
            $element->setData('after_element_html', $block);
        }
        if ($element->getId() == 'comment') {
            $element->addClass('required-for-others');
        }
        return $this;
    }
}
