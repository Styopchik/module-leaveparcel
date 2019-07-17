<?php
/**
 * Created by Andrew Stepanchuk.
 * Date: 10.07.19
 * Time: 14:23
 */

namespace Netzexpert\LeaveParcel\Setup\Patch\Data;

use Exception;
use Magento\Customer\Model\Attribute\Backend\Data\Boolean;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Netzexpert\LeaveParcel\Model\Customer\Attribute\Source\Places;
use Symfony\Component\Console\Output\ConsoleOutput;

class AddCustomAttributes implements DataPatchInterface, PatchRevertableInterface
{
    /** @var ModuleDataSetupInterface  */
    private $moduleDataSetup;

    /** @var CustomerSetupFactory  */
    private $customerSetupFactory;

    /** @var AttributeRepositoryInterface  */
    private $attributeRepository;

    /** @var ConsoleOutput  */
    private $consoleOutput;

    /** @var array  */
    private $attributes = [
        'leave_parcel'  => [
            'label'                 => 'Leave parcel',
            'input'                 => 'boolean',
            'type'                  => 'int',
            'backend'               => Boolean::class,
            'position'              => 900,
            'required'              => false,
            'system'                => false,
            'is_user_defined'       => true,
            'is_used_in_grid'       => false,
            'is_visible_in_grid'    => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false
        ],
        'leave_at'      => [
            'label'                 => 'Where to leave',
            'input'                 => 'select',
            'type'                  => 'varchar',
            'backend'               => '',
            'required'              => false,
            'is_user_defined'       => true,
            'source'                => Places::class,
            'position'              => 901,
            'system'                => false,
            'is_used_in_grid'       => false,
            'is_visible_in_grid'    => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false
        ],
        'comment'       => [
            'label'                 => 'Comment',
            'input'                 => 'textarea',
            'type'                  => 'text',
            'backend'               => '',
            'position'              => 902,
            'required'              => false,
            'is_user_defined'       => true,
            'system'                => false,
            'is_used_in_grid'       => false,
            'is_visible_in_grid'    => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false
        ]
    ];

    /**
     * AddCustomAttributes constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
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
        $this->attributeRepository  = $attributeRepository;
        $this->consoleOutput        = $consoleOutput;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
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
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        foreach ($this->attributes as $attributeCode => $attributeConfig) {
            try {
                $customerSetup->addAttribute(
                    'customer_address',
                    $attributeCode,
                    $attributeConfig
                );
            } catch (Exception $exception) {
                $this->consoleOutput->getErrorOutput()->writeln($exception->getMessage());
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function revert()
    {
        foreach ($this->attributes as $attributeCode => $attributeConfig) {
            try {
                $attribute = $this->attributeRepository->get('customer_address', $attributeCode);
                $this->attributeRepository->delete($attribute);
            } catch (LocalizedException $exception) {
                $this->consoleOutput->getErrorOutput()->writeln($exception->getMessage());
            }
        }
    }
}
