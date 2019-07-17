<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 16.07.19
 * Time: 9:46
 */

namespace Netzexpert\LeaveParcel\Plugin\Customer\Model\Address;

use Magento\Customer\Model\Address\Config;
use Magento\Framework\DataObject;

class ConfigPlugin
{
    /**
     * @param Config $addressConfig
     * @param array $formats
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetFormats(
        Config $addressConfig,
        $formats
    ) {
        /** @var DataObject $format */
        foreach ($formats as $format) {
            $default_format = $format->getData('default_format');
            if (strpos($default_format, '{{depend leave_at}}') !== false) {
                continue;
            }
            switch ($format->getData('code')) {
                case 'html':
                    $default_format .=
                        "{{depend leave_at}}<br />" . __('Leave at:') .
                        " {{var leave_at}}{{/depend}}{{depend comment}}<br />" . __('Comment:') .
                        "<br />{{var comment}}{{/depend}}";
                    break;
                case 'oneline':
                    $default_format .=
                        "{{depend leave_at}}" . __('Leave at:') .
                        " {{var leave_at}}{{/depend}}{{depend comment}}" . __('Comment:') . " {{var comment}}{{/depend}}";
                    break;
                case 'pdf':
                case 'text':
                default:
                $default_format .=
                    "{{depend leave_at}} |\n
                    " . __('Leave at:') . " {{var leave_at}}{{/depend}}{{depend comment}}|\n
                    " . __('Comment:') . " |\n{{var comment}}{{/depend}}";
                break;
            }
            $format->setData('default_format', $default_format);
        }
        return $formats;
    }
}
