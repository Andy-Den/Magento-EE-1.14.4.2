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
 * One page checkout order review xml renderer
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Checkout_Order_Review extends Mage_Checkout_Block_Onepage_Review
{
    /**
     * Render order review xml
     *
     * @return string
     */
    protected function _toHtml()
    {
        $orderXmlObj = Mage::getModel('xmlconnect/simplexml_element', '<order></order>');

        /**
         * Order items
         */
        $products = $this->getChildHtml('order_products');
        if ($products) {
            $productsXmlObj = Mage::getModel('xmlconnect/simplexml_element', $products);
            $orderXmlObj->appendChild($productsXmlObj);
        }

        /**
         * Totals
         */
        $totalsXml = $this->getChildHtml('totals');
        if ($totalsXml) {
            $totalsXmlObj = Mage::getModel('xmlconnect/simplexml_element', $totalsXml);
            $orderXmlObj->appendChild($totalsXmlObj);
        }

        /**
         * Agreements
         */
        $agreements = $this->getChildHtml('agreements');
        if ($agreements) {
            $agreementsXmlObj = Mage::getModel('xmlconnect/simplexml_element', $agreements);
            $orderXmlObj->appendChild($agreementsXmlObj);
        }

        return $orderXmlObj->asNiceXml();
    }
}
