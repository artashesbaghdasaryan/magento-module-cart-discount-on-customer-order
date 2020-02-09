<?php
namespace Fidem\Coupon\Model;

class ConfigSource implements \Magento\Framework\Option\ArrayInterface
{
    protected $ruleFactory;
    public function __construct(
        \Magento\SalesRule\Model\RuleFactory $ruleFactory
    ){
        $this->ruleFactory = $ruleFactory;
    }

    public function toOptionArray()
    {
        $rules = $this->ruleFactory->create()->getCollection()
        ->addFieldToFilter('use_auto_generation', true);
        $data[] = [
            'value' => '',
            'label' => __('Please select')
        ];
        foreach ($rules as $key => $rule) {
            $data[$key] = [
                'value' => $rule->getRuleId(),
                'label' => $rule->getName()
            ];
        }
        return $data;
    }
}