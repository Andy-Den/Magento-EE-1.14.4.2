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
 * @category    Enterprise
 * @package     Enterprise_GiftWrapping
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Customer balance block for order
 *
 */
class Enterprise_GiftWrapping_Block_Sales_Totals extends Mage_Core_Block_Template
{
    /**
     * Initialize gift wrapping and printed card totals for order/invoice/creditmemo
     *
     * @return Enterprise_GiftWrapping_Block_Sales_Totals
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $source  = $parent->getSource();
        $totals = Mage::helper('enterprise_giftwrapping')->getTotals($source);
        foreach ($totals as $total) {
            $this->getParentBlock()->addTotalBefore(new Varien_Object($total), 'tax');
        }
        return $this;
    }
}
