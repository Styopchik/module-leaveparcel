<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 09.07.19
 * Time: 14:37
 */

namespace Netzexpert\LeaveParcel\Api;

use Magento\Framework\Api\AttributeInterface;

interface LeaveParcelDataInterface
{
    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @return string
     */
    public function getValue();

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value);
}
