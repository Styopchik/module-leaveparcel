<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 12.07.19
 * Time: 11:03
 */

namespace Netzexpert\LeaveParcel\Plugin\Customer\Block\Address;

use Magento\Customer\Block\Address\Edit;
use Magento\Framework\View\LayoutInterface;
use Netzexpert\LeaveParcel\Block\Customer\Address\Edit\LeaveParcelData;

/**
 * Class EditPlugin
 * @package Netzexpert\LeaveParcel\Plugin\Customer\Block\Address
 */
class EditPlugin
{
    /** @var LayoutInterface  */
    private $layout;

    /**
     * EditPlugin constructor.
     * @param LayoutInterface $layout
     */
    public function __construct(
        LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    /**
     * @param Edit $editBlock
     * @param string $nameBlockHtml
     * @return string
     */
    public function afterGetNameBlockHtml(
        Edit $editBlock,
        $nameBlockHtml
    ) {
        $additionalBlock = $this->layout->createBlock(
            LeaveParcelData::class,
            'additional_attributes',
            ['address' => $editBlock->getAddress()]);
        return $nameBlockHtml . $additionalBlock->toHtml();
    }
}
