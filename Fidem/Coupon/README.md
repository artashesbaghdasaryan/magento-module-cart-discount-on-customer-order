# Mage2 Module Fidem Coupon

    ``fidem/module-coupon``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities


## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Fidem`
 - Enable the module by running `php bin/magento module:enable Fidem_Coupon`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require fidem/module-coupon`
 - enable the module by running `php bin/magento module:enable Fidem_Coupon`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration

 - enable (coupon/general/enable)


## Specifications

 - Observer
	- sales_order_save_after > Fidem\Coupon\Observer\Frontend\Sales\OrderSaveAfter

 - Helper
	- Fidem\Coupon\Helper\Coupon


## Attributes



