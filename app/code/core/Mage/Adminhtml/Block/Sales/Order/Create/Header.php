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
 * @package     Mage_Adminhtml
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Create order form header
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Sales_Order_Create_Header extends Mage_Adminhtml_Block_Sales_Order_Create_Abstract
{
    protected function _toHtml()
    {
        if ($this->_getSession()->getOrder()->getId()) {
            return '<h3 class="icon-head head-sales-order">' . Mage::helper('sales')->__(
                'Edit Order #%s',
                $this->escapeHtml($this->_getSession()->getOrder()->getIncrementId())
            ) . '</h3>';
        }

        $customerId = $this->getCustomerId();
        $storeId    = $this->getStoreId();
        $out = '';
        if ($customerId && $storeId) {
            $out.= Mage::helper('sales')->__('Create New Order for %s in %s', $this->getCustomer()->getName(), $this->getStore()->getName());
        }
        elseif (!is_null($customerId) && $storeId){
            $out.= Mage::helper('sales')->__('Create New Order for New Customer in %s', $this->getStore()->getName());
        }
        elseif ($customerId) {
            $out.= Mage::helper('sales')->__('Create New Order for %s', $this->getCustomer()->getName());
        }
        elseif (!is_null($customerId)){
            $out.= Mage::helper('sales')->__('Create New Order for New Customer');
        }
        else {
            $out.= Mage::helper('sales')->__('Create New Order');
        }
        $out = $this->escapeHtml($out);
        $out = '<h3 class="icon-head head-sales-order">' . $out . '</h3>';
        return $out;
    }
}
