<?php
/**
 * Copyright (c) 2019 Artashes Baghdasaryan
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Fidem\Coupon\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context ;
use Magento\Framework\App\Config\ScopeConfigInterface ;

class Coupon extends AbstractHelper
{
    
   /**
   * Recipient is enabled config path
   */
   const XML_PATH_FIDEM_COUPON_IS_ENABLED = 'fcoupon/general/enable';
   const XML_PATH_FIDEM_COUPON_PREFIX = 'fcoupon/general/prefix';

   const XML_PATH_FIDEM_COUPON_INRANGE_RULEID = 'fcoupon/inrangeconfig/rule_id';
   const XML_PATH_FIDEM_COUPON_PRICESTART = 'fcoupon/inrangeconfig/price_start';
   const XML_PATH_FIDEM_COUPON_PRICEEND = 'fcoupon/inrangeconfig/price_end';
   const XML_PATH_FIDEM_COUPON_INRANGE_TEXT = 'fcoupon/inrangeconfig/coupon_inrange_text';

   const XML_PATH_FIDEM_COUPON_UPPERPRICE_RULEID = 'fcoupon/upperpriceconfig/rule_id';
   const XML_PATH_FIDEM_COUPON_PRICE_TO_UP = 'fcoupon/upperpriceconfig/price_to_up_sale';
   const XML_PATH_FIDEM_COUPON_UPPERPRICE_TEXT = 'fcoupon/upperpriceconfig/coupon_uptorange_text';


   /**
    * @var \Magento\Framework\App\Config\ScopeConfigInterface
    */
   protected $scopeConfig;

 
   
    public function __construct(
        Context $context ,
        ScopeConfigInterface $scopeConfig
          
    ) {
        parent::__construct($context);
    

    }
    
  /*
     * @return number
     */
    public function labelUpperPriceCoupon() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_UPPERPRICE_TEXT, $storeScope);
    }
      /*
     * @return number
     */
    public function labelInRangeCoupon() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_INRANGE_TEXT, $storeScope);
    }

      /*
     * @return number
     */
    public function priceUpToRange() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_PRICE_TO_UP, $storeScope);
    }


      /*
     * @return integer
     */
    public function upToRangeRuleId() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_UPPERPRICE_RULEID, $storeScope);
    }

   
     /*
     * @return number
     */
    public function priceRangeEnd() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_PRICEEND, $storeScope);
    }


    /*
     * @return number
     */
    public function priceRangeStart() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_PRICESTART, $storeScope);
    }

     /*
     * @return integer
     */
    public function inRangeRuleId() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_INRANGE_RULEID, $storeScope);
    }


    

    /*
     * @return string
     */
    public function getCouponPrefix() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_PREFIX, $storeScope);
    }

   /*
     * @return bool
     * checking is enabled module
     */
    public function isEnabled() {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->scopeConfig->getValue(self::XML_PATH_FIDEM_COUPON_IS_ENABLED, $storeScope);
    }

    
}