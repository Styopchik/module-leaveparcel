<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 09.07.19
 * Time: 14:39
 */

namespace Netzexpert\LeaveParcel\Model;

use Magento\Framework\Api\AbstractSimpleObject;
use Netzexpert\LeaveParcel\Api\LeaveParcelDataInterface;

class LeaveParcelData extends AbstractSimpleObject implements LeaveParcelDataInterface
{

    const LABEL = 'label';

    const VALUE = 'value';
    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return $this->_get(self::LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setLabel($label)
    {
        $this->_data[self::LABEL] = $label;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->_get(self::VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setValue($value)
    {
        $this->_data[self::VALUE] = $value;
        return $this;
    }

}
