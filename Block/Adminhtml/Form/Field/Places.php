<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 08.07.19
 * Time: 14:54
 */

namespace Netzexpert\LeaveParcel\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Places extends AbstractFieldArray
{
    /**
     * @inheritDoc
     */
    protected function _prepareToRender()
    {
        $this->addColumn('place', ['label' => __('Place'), 'class' => 'required-entry']);
        $this->addColumn('sortOrder', ['label' => __('Sort Order'), 'class' => 'required-number validate-greater-than-zero']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Place');
    }

}
