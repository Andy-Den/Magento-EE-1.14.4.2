<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition End User License Agreement
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magento.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Shipping
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Fields:
 * - carrier: ups
 * - carrierTitle: United Parcel Service
 * - method: 2day
 * - methodTitle: UPS 2nd Day Priority
 * - price: $9.40 (cost+handling)
 * - cost: $8.00
 */
class Mage_Shipping_Model_Rate_Result_Method extends Mage_Shipping_Model_Rate_Result_Abstract
{
    /**
     * Round shipping carrier's method price
     *
     * @param string|float|int $price
     * @return Mage_Shipping_Model_Rate_Result_Method
     */
    public function setPrice($price)
    {
        $this->setData('price', Mage::app()->getStore()->roundPrice($price));
        return $this;
    }
}
