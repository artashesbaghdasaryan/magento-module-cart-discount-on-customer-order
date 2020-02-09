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

namespace Fidem\Coupon\Observer\Sales;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Fidem\Coupon\Helper\Coupon as CouponHelper;
use Magento\SalesRule\Model\CouponGenerator;
use Magento\SalesRule\Model\Coupon as CouponModel;

class OrderSaveAfter implements ObserverInterface
{
   
    const INITIAL_COUPON_CODES_QTY = 1;
    const LENGTH = 10;

    protected $_couponHelper;
    protected $couponGenerator;
    protected $couponModel;
    public function __construct(
        CouponGenerator $couponGenerator,
        CouponHelper $couponHelper,
        CouponModel $coupon
    ) {
        $this->couponGenerator = $couponGenerator;
        $this->_couponHelper = $couponHelper;
        $this->couponModel = $coupon;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {      
           if(!$this->_couponHelper->isEnabled()){
               return $this;
           }
           $order = $observer->getEvent()->getOrder();
           if($order->getState() != "complete")
           {
             //  return $this;   
           }

           $prefix = $this->_couponHelper->getCouponPrefix();
           if(empty($prefix)){
            $prefix  = "FIDEM-"; 
           }
           if(($order->getTotalDue() >= $this->_couponHelper->priceRangeStart()) && $order->getTotalDue() <=  $this->_couponHelper->priceRangeEnd()){
            
            $params = ['length' => self::LENGTH, 'prefix' => $prefix ];
            $coupon =  $this->createCouponCode(self::INITIAL_COUPON_CODES_QTY, $this->_couponHelper->inRangeRuleId(), $params);
            
            $order->setFidemCouponCode($this->_couponHelper->labelInRangeCoupon().": ".$coupon[0]);
            $order->getResource()->saveAttribute($order, "fidem_coupon_code");
          
        }

        if($order->getTotalDue() >=  $this->_couponHelper->priceUpToRange() ){
            $params = ['length' => self::LENGTH, 'prefix' => $prefix ];
            $coupon = $this->createCouponCode(self::INITIAL_COUPON_CODES_QTY, $this->_couponHelper->upToRangeRuleId(), $params);
            $order->setFidemCouponCode($this->_couponHelper->labelInRangeCoupon().": ".$coupon[0]);
            $order->getResource()->saveAttribute($order, "fidem_coupon_code");
         
        }
        return $order;
    }
    
    public function createCouponCode(int $qty, int $ruleId, array $params = [])
    {
        if (!$qty || !$ruleId) {
            return;
        }
        $params['rule_id'] = $ruleId;
        $params['qty'] = $qty;
        $params['to_date'] = date("Y-m-d", strtotime("+1 week"));
       $coupon =  $this->couponGenerator->generateCodes($params);
       $couponObj =  $this->couponModel->loadByCode($coupon[0]);
       $couponObj->setExpirationDate(date("Y-m-d", strtotime("+1 week")))->save();
       return  $coupon;
    }


}

