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
 * @package     Mage_Paypal
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Paypal Express Onepage checkout block for Billing Address
 *
 * @category   Mage
 * @package    Mage_Paypal
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Paypal_Block_Express_Review_Billing extends Mage_Checkout_Block_Onepage_Billing
{
    /**
     * Return Sales Quote Address model
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddress()
    {
        if (is_null($this->_address)) {
            if ($this->isCustomerLoggedIn() || $this->getQuote()->getBillingAddress()) {
                $this->_address = $this->getQuote()->getBillingAddress();
                if (!$this->_address->getFirstname()) {
                    $this->_address->setFirstname($this->getQuote()->getCustomer()->getFirstname());
                }
                if (!$this->_address->getMiddlename()) {
                    $this->_address->setMiddlename($this->getQuote()->getCustomer()->getMiddlename());
                }
                if (!$this->_address->getLastname()) {
                    $this->_address->setLastname($this->getQuote()->getCustomer()->getLastname());
                }
            } else {
                $this->_address = Mage::getModel('sales/quote_address');
            }
        }

        return $this->_address;
    }
}
