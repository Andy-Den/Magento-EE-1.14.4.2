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
 * PayPal MECL order details xml renderer
 *
 * @category    Mage
 * @package     Mage_Xmlconnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Cart_Paypal_Mecl_OrderDetails extends Mage_Paypal_Block_Express_Review_Details
{
    /**
     * Add cart details to XML object
     *
     * @param Mage_XmlConnect_Model_Simplexml_Element $reviewXmlObj
     * @return Mage_XmlConnect_Model_Simplexml_Element
     */
    public function addDetailsToXmlObj(Mage_XmlConnect_Model_Simplexml_Element $reviewXmlObj)
    {
        $itemsXmlObj = $reviewXmlObj->addChild('ordered_items');
        foreach ($this->getItems() as $item) {
            $this->getItemXml($item, $itemsXmlObj);
        }

        $this->getChild('totals')->setCartXmlObject($reviewXmlObj)->_toHtml();

        return $reviewXmlObj;
    }

    /**
     * Get item row xml
     *
     * @param Mage_Sales_Model_Quote_Item $item
     * @param Mage_XmlConnect_Model_Simplexml_Element $reviewXmlObj
     * @return Mage_XmlConnect_Model_Simplexml_Element
     */
    public function getItemXml(
        Mage_Sales_Model_Quote_Item $item, Mage_XmlConnect_Model_Simplexml_Element $reviewXmlObj
    ) {
        $renderer = $this->getItemRenderer($item->getProductType())->setItem($item)->setQuote($this->getQuote());
        return $renderer->addProductToXmlObj($reviewXmlObj);
    }

    /**
     * Add renderer for item product type
     *
     * @param string $productType
     * @param string $blockType
     * @param string $template
     * @return Mage_Checkout_Block_Cart_Abstract
     */
    public function addItemRender($productType, $blockType, $template)
    {
        $this->_itemRenders[$productType] = array(
            'block' => $blockType, 'template' => $template, 'blockInstance' => null
        );
        return $this;
    }
}
