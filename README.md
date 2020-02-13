# magento-module-cart-discount-on-customer-order
# Mage2 Module Coupon

    ``fidem/module-coupon``
 - [Installation](#Installation)
 - [information](#information)

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Fidem`
 - Enable the module by running `php bin/magento module:enable Fidem_Coupon`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## information

- On module installation - creating 2 sales cart rules with 30% and 40% 
-at Admin side we have configurations
1st is for in some price range discount and selection of rule 
- you can select the range and  create coupon code and send to customer 
- coupon code is valid for 1 week.
- 2nd is upper price discount 
- you can select some price and upper that amount of total give create coupon code and send to customer 
- coupon code is valid for 1 week.
- The coupon is sending by mail.
