<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 10.07.19
 * Time: 14:49
 */

namespace Netzexpert\LeaveParcel\Model\Customer\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

class Places extends AbstractSource
{
    /** @var ScopeConfigInterface  */
    private $scopeConfig;

    /** @var Json  */
    private $json;

    /**
     * Places constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Json $json
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Json $json
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->json         = $json;
    }

    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        $configValue = $this->scopeConfig->getValue('leave_parcel/general/places');
        $options = $this->json->unserialize(
            ($configValue) ? $configValue : '{}'
        );
        $sortOrder = array_column($options, 'sortOrder');
        array_multisort($sortOrder, SORT_ASC, $options);
        $optionsArray = [];
        foreach ($options as $option) {
            if (empty($option['place'])) {
                continue;
            }
            $optionsArray[] = ['value' => $option['place'], 'label' => $option['place']];
        }
        if ($this->scopeConfig->getValue('leave_parcel/general/show_custom')) {
            $optionsArray[] = ['value' => __('Other'), 'label' => __('Other')];
        }
        return $optionsArray;
    }

}
