<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 11.07.19
 * Time: 9:28
 */

namespace Netzexpert\LeaveParcel\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Symfony\Component\Console\Output\ConsoleOutput;

class SetAttributesForms implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface  */
    private $moduleDataSetup;

    /** @var CustomerSetupFactory  */
    private $customerSetupFactory;

    /** @var ConsoleOutput  */
    private $consoleOutput;

    /** @var array  */
    private $forms = [
        'customer_address_edit',
        'customer_register_address',
        'adminhtml_customer_address',
        'adminhtml_checkout'
    ];

    private $attributes = [
        'leave_parcel',
        'leave_at',
        'comment'
    ];

    /**
     * AddCustomAttributes constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ConsoleOutput $consoleOutput
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepositoryInterface $attributeRepository,
        ConsoleOutput $consoleOutput
    ) {
        $this->moduleDataSetup      = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->consoleOutput        = $consoleOutput;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [
            AddCustomAttributes::class
        ];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        foreach ($this->attributes as $attributeCode) {
            try {
                /** @var CustomerSetup $customerSetup */
                $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
                $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', $attributeCode);
                $attribute->setData('used_in_forms', $this->forms);
                $attribute->save();
            } catch (LocalizedException $exception) {
                $this->consoleOutput->getErrorOutput()->writeln($exception->getMessage());
            }
        }
        return $this;
    }

}
