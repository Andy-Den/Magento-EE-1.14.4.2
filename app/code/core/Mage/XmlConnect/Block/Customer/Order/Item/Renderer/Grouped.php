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
 * Customer order item xml renderer for grouped product type
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Customer_Order_Item_Renderer_Grouped extends Mage_Sales_Block_Order_Item_Renderer_Grouped
{
    /**
     * Default product type
     */
    const DEFAULT_PRODUCT_TYPE = 'default';

    /**
     * Add item to XML object
     * (get from template: sales/order/items/renderer/default.phtml)
     *
     * @param Mage_XmlConnect_Model_Simplexml_Element $orderItemXmlObj
     * @return null
     */
    public function addItemToXmlObject(Mage_XmlConnect_Model_Simplexml_Element $orderItemXmlObj)
    {
        $item = $this->getItem()->getOrderItem();
        if (!$item) {
            $item = $this->getItem();
        }
        $productType = $item->getRealProductType();
        if (!$productType) {
            $productType = self::DEFAULT_PRODUCT_TYPE;
        }
        $renderer = $this->getRenderedBlock()->getItemRenderer($productType);
        $renderer->setItem($this->getItem())->setNewApi($this->getNewApi());
        $renderer->addItemToXmlObject($orderItemXmlObj);
    }
}
