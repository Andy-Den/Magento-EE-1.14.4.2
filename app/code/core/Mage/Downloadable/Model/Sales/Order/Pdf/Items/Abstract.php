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
 * @package     Mage_Downloadable
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Order Downloadable Pdf Items renderer
 *
 * @category   Mage
 * @package    Mage_Downloadable
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Downloadable_Model_Sales_Order_Pdf_Items_Abstract extends Mage_Sales_Model_Order_Pdf_Items_Abstract
{
    /**
     * Downloadable links purchased model
     *
     * @var Mage_Downloadable_Model_Link_Purchased
     */
    protected $_purchasedLinks = null;

    /**
     * Return Purchased link for order item
     *
     * @return Mage_Downloadable_Model_Link_Purchased
     */
    public function getLinks()
    {
        $this->_purchasedLinks = Mage::getModel('downloadable/link_purchased')
            ->load($this->getOrder()->getId(), 'order_id');
        $purchasedItems = Mage::getModel('downloadable/link_purchased_item')->getCollection()
            ->addFieldToFilter('order_item_id', $this->getItem()->getOrderItem()->getId());
        $this->_purchasedLinks->setPurchasedItems($purchasedItems);

        return $this->_purchasedLinks;
    }

    /**
     * Return Links Section Title for order item
     *
     * @return string
     */
    public function getLinksTitle()
    {
        if ($this->_purchasedLinks->getLinkSectionTitle()) {
            return $this->_purchasedLinks->getLinkSectionTitle();
        }
        return Mage::getStoreConfig(Mage_Downloadable_Model_Link::XML_PATH_LINKS_TITLE);
    }
}
