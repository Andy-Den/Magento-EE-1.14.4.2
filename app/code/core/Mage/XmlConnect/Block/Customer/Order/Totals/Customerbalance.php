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
 * @package     Mage_XmlConnect
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Customer order Customer balance totals xml renderer
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Customer_Order_Totals_Customerbalance
    extends Enterprise_CustomerBalance_Block_Sales_Order_Customerbalance
{
    /**
     * Add order total rendered to XML object
     *
     * @param $totalsXml Mage_XmlConnect_Model_Simplexml_Element
     * @return null
     */
    public function addToXmlObject(Mage_XmlConnect_Model_Simplexml_Element $totalsXml)
    {
        if ($this->getNewApi()) {
            $this->addToXmlObjectApi23($totalsXml);
            return;
        }

        $balance = $this->getSource()->getCustomerBalanceAmount();
        if ($balance) {
            $totalsXml->addCustomChild(
                $this->getTotal()->getCode(),
                '-' . $this->_formatPrice($balance),
                array('label' => Mage::helper('enterprise_giftcardaccount')->__('Store Credit'))
            );
        }
    }

    /**
     * Add order total rendered to XML object. Api version 23
     *
     * @param $totalsXml Mage_XmlConnect_Model_Simplexml_Element
     * @return null
     */
    public function addToXmlObjectApi23(Mage_XmlConnect_Model_Simplexml_Element $totalsXml)
    {
        $balance = $this->getSource()->getCustomerBalanceAmount();
        if ($balance) {
            $totalsXml->addCustomChild('item', '-' . $this->_formatPrice($balance), array(
                'id' => $this->getTotal()->getCode(),
                'label' => Mage::helper('enterprise_giftcardaccount')->__('Store Credit')
            ));
        }
    }

    /**
     * Format price using order currency
     *
     * @param   float $amount
     * @return  string
     */
    protected function _formatPrice($amount)
    {
        return Mage::helper('xmlconnect/customer_order')->formatPrice($this, $amount);
    }
}
