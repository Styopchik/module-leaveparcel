<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 08.07.19
 * Time: 11:43
 */

namespace Netzexpert\LeaveParcel\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\ArrayManager;
use Netzexpert\LeaveParcel\Model\Customer\Attribute\Source\Places;

class LayoutProcessor implements LayoutProcessorInterface
{
    /** @var ScopeConfigInterface  */
    private $scopeConfig;

    /** @var Json  */
    private $json;

    /**
     * @var Places
     */
    private $placesModel;
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * LayoutProcessor constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Places $placesModel
     * @param Json $json
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Places $placesModel,
        Json $json,
        ArrayManager $arrayManager
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->json         = $json;
        $this->placesModel = $placesModel;
        $this->arrayManager = $arrayManager;
    }

    /**
     * @inheritDoc
     */
    public function process($jsLayout)
    {
        if (!$this->scopeConfig->getValue('leave_parcel/general/enabled')) {
            return $jsLayout;
        }
        $jsLayout["components"]["checkout"]["children"]["steps"]["children"]["shipping-step"]["children"]["shippingAddress"]["children"]["shipping-address-fieldset"]["children"]['leave_parcel'] = [
            'component' => 'Netzexpert_LeaveParcel/js/form/element/leave-parcel',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'prefer' => 'checkbox'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.leave_parcel',
            'label' => __('Leave parcel'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'sortOrder' => 150,
            'tracks' => [
                'value' => true
            ],
            'additionalClasses' => 'leave-parcel',
            'notice' => __(
                "With the order you give %1 the permission to deposit the shipments addressed to you in a place specified by you (for example, garage, gazebo, covered terrace, neighbors), without you signing for the receipt of the shipment (s).",
                $this->scopeConfig->getValue('general/store_information/name')
            ),
            'valueMap' => [
                'true' => true,
                'false' => false
            ]
        ];
        $jsLayout["components"]["checkout"]["children"]["steps"]["children"]["shipping-step"]["children"]["shippingAddress"]["children"]["shipping-address-fieldset"]["children"]['leave_at'] = [
            'component' => 'Magento_Ui/js/form/element/checkbox-set',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes'
            ],
            'provider' => 'checkoutProvider',
            'dataScope' => 'shippingAddress.custom_attributes.leave_at',
            'label' => __('Where to leave'),
            'deps' => [],
            'required' => true,
            'validation' => [
                'required-entry' => true
            ],
            'additionalClasses' => 'leave-at',
            'sortOrder' => 160,
            'visible' => false,
            'options' => $this->placesModel->getAllOptions()
        ];
        if ($this->scopeConfig->getValue('leave_parcel/general/show_custom')) {
            $jsLayout["components"]["checkout"]["children"]["steps"]["children"]["shipping-step"]["children"]["shippingAddress"]["children"]["shipping-address-fieldset"]["children"]['comment'] = [
                'component' => 'Netzexpert_LeaveParcel/js/form/element/comment',
                'config' => [
                    'customScope' => 'shippingAddress.custom_attributes',
                    'template' => 'ui/form/field',
                ],
                'deps' => ['checkout.steps.shipping-step.shippingAddress.shipping-address-fieldset.leave_parcel'],
                'provider' => 'checkoutProvider',
                'visible' => false,
                'dataScope' => 'shippingAddress.custom_attributes.comment',
                'placeholder' => __('E.g .: greenhouse, storage location with access code'),
                'label' => __('Your comment'),
                'additionalClasses' => 'comment',
                'sortOrder' => 170,

            ];
        }
        // to remove Leave parcel attributes from billing address form in checkout
        $path = $this->arrayManager->findPath('form-fields', $jsLayout);
        $fields = ['leave_parcel', 'leave_at', 'comment'];
        foreach ($fields as $field) {
            $jsLayout = $this->arrayManager->remove($path . '/children/' . $field, $jsLayout);
        }
        return $jsLayout;
    }
}
