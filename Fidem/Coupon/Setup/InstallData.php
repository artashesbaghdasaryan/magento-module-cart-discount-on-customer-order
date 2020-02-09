<?php

namespace Fidem\Coupon\Setup;

use Fidem\Coupon\Setup\SetupService\CreateCartPriceRuleService;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Setup\SalesSetupFactory;

/**
 * Class InstallData
 */
class InstallData implements InstallDataInterface
{
    /**
     * Create Cart Price Rule Service
     *
     * @var CreateCartPriceRuleService
     */
    protected $createCartPriceRuleService;
    
    /**
     * @var SalesSetupFactory
     */
    protected $salesSetupFactory;
  

    /**
     * InstallData constructor
     *
     * @param CreateCartPriceRuleService $createCartPriceRuleService
     *  * @param SalesSetupFactory $salesSetupFactory
     */
    public function __construct(CreateCartPriceRuleService $createCartPriceRuleService, SalesSetupFactory $salesSetupFactory  )
    {
        $this->createCartPriceRuleService = $createCartPriceRuleService;
        $this->salesSetupFactory = $salesSetupFactory;
        

    }

    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        try {
            $this->createCartPriceRuleService->execute();
        } catch (\Throwable $th) {
            //throw $th;
        }
      
        $setup->getConnection()->startSetup();

        $salesInstaller = $this->salesSetupFactory->create(['setup' =>  $setup]);
        $salesInstaller->addAttribute(
            \Magento\Sales\Model\Order::ENTITY ,
            'fidem_coupon_code',
            [
                'type' => 'varchar',
                'lenght' =>255,
                'visible' => false,
                'required' => false,

            ]
         );

       
     $setup->getConnection()->endSetup();

    }
}