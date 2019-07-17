<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 12.07.19
 * Time: 11:10
 */

namespace Netzexpert\LeaveParcel\Block\Customer\Address\Edit;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Block\Address\Edit;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\Session;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Directory\Model\ResourceModel\Region\CollectionFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\App\Cache\Type\Config;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\FormFactory;

class LeaveParcelData extends Edit
{
    private $attributeRepository;

    private $formElementFactory;

    private $formFactory;

    /**
     * LeaveParcelData constructor.
     * @param Context $context
     * @param DirectoryHelper $directoryHelper
     * @param EncoderInterface $jsonEncoder
     * @param Config $configCacheType
     * @param CollectionFactory $regionCollectionFactory
     * @param \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory
     * @param Session $customerSession
     * @param AddressRepositoryInterface $addressRepository
     * @param AddressInterfaceFactory $addressDataFactory
     * @param CurrentCustomer $currentCustomer
     * @param DataObjectHelper $dataObjectHelper
     * @param AttributeRepositoryInterface $attributeRepository
     * @param Factory $formElementFactory
     * @param array $data
     * @param AddressMetadataInterface|null $addressMetadata
     */
    public function __construct(
        Context $context,
        DirectoryHelper $directoryHelper,
        EncoderInterface $jsonEncoder,
        Config $configCacheType,
        CollectionFactory $regionCollectionFactory,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        Session $customerSession,
        AddressRepositoryInterface $addressRepository,
        AddressInterfaceFactory $addressDataFactory,
        CurrentCustomer $currentCustomer,
        DataObjectHelper $dataObjectHelper,
        AttributeRepositoryInterface $attributeRepository,
        Factory $formElementFactory,
        FormFactory $formFactory,
        array $data = [],
        AddressMetadataInterface $addressMetadata = null
    ) {
        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $customerSession,
            $addressRepository,
            $addressDataFactory,
            $currentCustomer,
            $dataObjectHelper,
            $data,
            $addressMetadata
        );
        $this->attributeRepository  = $attributeRepository;
        $this->formElementFactory   = $formElementFactory;
        $this->formFactory          = $formFactory;
    }

    /**
     * @param AttributeInterface $customAttribute
     * @return string
     */
    public function getAttributeInput($customAttribute)
    {
        try {
            $attribute = $this->attributeRepository->get('customer_address', $customAttribute->getAttributeCode());
            $type = $attribute->getFrontendInput();
            $data = [
                'label'     => __($attribute->getDefaultFrontendLabel()),
                'value'     => $customAttribute->getValue(),
                'html_id'   => $attribute->getAttributeCode(),
                'name'      => $attribute->getAttributeCode(),
                'no_span'   => true
            ];
            if ($type == 'boolean') {
                $type = 'checkbox';
                $data['checked'] = $data['value'];
            }
            if ($attribute->getAttributeCode() == 'leave_parcel') {
                $data['after_element_html'] = __(
                    "With the order you give %1 the permission to deposit the shipments addressed to you in a place specified by you (for example, garage, gazebo, covered terrace, neighbors), without you signing for the receipt of the shipment (s).",
                    $this->_scopeConfig->getValue('general/store_information/name')
                );
            }
            if ($type == 'select') {
                $data['values'] = $attribute->getSource()->getAllOptions();
            }
            if ($attribute->getAttributeCode() == 'comment') {
                $script = $this->getLayout()->createBlock(Template::class)
                    ->setTemplate('Netzexpert_LeaveParcel::customer/address/edit/parcel-script.phtml')
                    ->toHtml();
                $data['after_element_html'] = $script;
            }
            $form = $this->formFactory->create();
            $required = $attribute->getIsRequired() ? ' _required' : '';

            $html = "<div id='field-" . $customAttribute->getAttributeCode() . "' class=\"field " . $customAttribute->getAttributeCode() . $required . "\">";
            $element = $this->formElementFactory->create($type, ['data' => $data])
                ->setForm($form)
                ->removeClass('admin__field')
                ->addClass('field')
                ->addClass($customAttribute->getAttributeCode());
            if ($attribute->getAttributeCode() == 'comment') {
                $element->addClass('required-for-others');
            }
            $html .= $element->getHtml();
            $html .= "</div>";
            return $html;
        } catch (LocalizedException $exception) {
            $this->_logger->error($exception->getMessage());
            return '';
        }
    }
}
