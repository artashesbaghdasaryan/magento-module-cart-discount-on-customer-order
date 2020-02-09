<?php

namespace Fidem\Coupon\Setup\SetupService;

use Exception;
use Magento\Backend\App\Area\FrontNameResolver as BackendFrontNameResolver;
use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroupCollection;
use Magento\Customer\Model\ResourceModel\Group\CollectionFactory as CustomerGroupCollectionFactory;
use Magento\Framework\App\State as AppState;
use Magento\SalesRule\Api\Data\RuleInterface;
use Magento\SalesRule\Api\Data\RuleInterfaceFactory;
use Magento\SalesRule\Api\RuleRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Class CreateCartPriceRuleService
 */
class CreateCartPriceRuleService
{
    /**
     * The initial number of generated coupon codes
     */
    const INITIAL_COUPON_CODES_QTY = 1;

    /**
     * Coupon Code Length
     */
    const LENGTH = 10;

    /**
     * Coupon Code Prefix
     */
    const PREFIX = 'TEST-';

    /**
     * Rule Repository
     *
     * @var RuleRepositoryInterface
     */
    protected $ruleRepository;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Catalog Price Rule Factory
     *
     * @var RuleInterfaceFactory
     */
    protected $cartPriceRuleFactory;

    /**
     * Customer Group Collection Factory
     *
     * @var CustomerGroupCollectionFactory
     */
    protected $customerGroupCollectionFactory;

    /**
     * App State
     *
     * @var AppState
     */
    protected $appState;

    /**
     * CreateCartPriceRuleService constructor
     *
     * @param RuleRepositoryInterface $ruleRepository
     * @param StoreManagerInterface $storeManager
     * @param AppState $appState
     * @param RuleInterfaceFactory $cartPriceRuleFactory
     * @param CustomerGroupCollectionFactory $customerGroupCollectionFactory
     */
    public function __construct(
        RuleRepositoryInterface $ruleRepository,
        StoreManagerInterface $storeManager,
        AppState $appState,
        RuleInterfaceFactory $cartPriceRuleFactory,
        CustomerGroupCollectionFactory $customerGroupCollectionFactory
    ) {
        $this->ruleRepository = $ruleRepository;
        $this->storeManager = $storeManager;
        $this->appState = $appState;
        $this->cartPriceRuleFactory = $cartPriceRuleFactory;
        $this->customerGroupCollectionFactory = $customerGroupCollectionFactory;
    }

    /**
     * Create cart price rule and generate coupon codes
     *
     * @return void
     *
     * @throws Exception
     */
    public function execute()
    {
        $customerGroupIds = $this->getAvailableCustomerGroupIds();
        $websiteIds = $this->getAvailableWebsiteIds();

        /** @var RuleInterface $cartPriceRule */
        $cartPriceRule = $this->cartPriceRuleFactory->create();

        // Set the required parameters.
          $cartPriceRule->setName('FIDEM_30%')
                        ->setIsAdvanced(true)
                        ->setStopRulesProcessing(false)
                        ->setDiscountQty(1)
                        ->setFromDate(date("Y-m-d")) 
                        ->setUsesPerCustomer(1)
                        ->setCouponType(2)
                        ->setSimpleAction(RuleInterface::DISCOUNT_ACTION_BY_PERCENT)
                        ->setDiscountAmount(30)
                        ->setIsActive(true)
                        ->setCustomerGroupIds($customerGroupIds)
                        ->setWebsiteIds($websiteIds)
                        ->setUsesPerCustomer(1)
                        ->setUseAutoGeneration(true);
                        
        $savedCartPriceRule = $this->appState->emulateAreaCode(
            BackendFrontNameResolver::AREA_CODE,
            [$this->ruleRepository, 'save'],
            [$cartPriceRule]
        );

          /** @var RuleInterface $cartPriceRule */
          $cartPriceRule = $this->cartPriceRuleFactory->create();
          $cartPriceRule->setName('FIDEM_40%')
                        ->setIsAdvanced(true)
                        ->setStopRulesProcessing(false)
                        ->setDiscountQty(1)
                        ->setFromDate(date("Y-m-d")) 
                        ->setUsesPerCustomer(1)
                        ->setCouponType(2)
                        ->setSimpleAction(RuleInterface::DISCOUNT_ACTION_BY_PERCENT)
                        ->setDiscountAmount(40)
                        ->setIsActive(true)
                        ->setCustomerGroupIds($customerGroupIds)
                        ->setWebsiteIds($websiteIds)
                        ->setUsesPerCustomer(1)
                        ->setUseAutoGeneration(true);
          $savedCartPriceRule = $this->appState->emulateAreaCode(
              BackendFrontNameResolver::AREA_CODE,
              [$this->ruleRepository, 'save'],
              [$cartPriceRule]
          );

    
    }

    /**
     * Get all available customer group IDs
     *
     * @return int[]
     */
    protected function getAvailableCustomerGroupIds()
    {
        /** @var CustomerGroupCollection $collection */
        $collection = $this->customerGroupCollectionFactory->create();
        $collection->addFieldToSelect('customer_group_id');
        $customerGroupIds = $collection->getAllIds();

        return $customerGroupIds;
    }

    /**
     * Get all available website IDs
     *
     * @return int[]
     */
    protected function getAvailableWebsiteIds()
    {
        $websiteIds = [];
        $websites = $this->storeManager->getWebsites();

        foreach ($websites as $website) {
            $websiteIds[] = $website->getId();
        }

        return $websiteIds;
    }
}