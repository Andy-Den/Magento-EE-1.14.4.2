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
 * @package     Mage_Checkout
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Multishipping checkout success information
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Checkout_Block_Multishipping_Success extends Mage_Checkout_Block_Multishipping_Abstract
{
    public function getOrderIds()
    {
        $ids = Mage::getSingleton('core/session')->getOrderIds(true);
//        Zend_Debug::dump(Mage::getSingleton('core/session')->getOrderIds());
        if ($ids && is_array($ids)) {
            return $ids;
            return implode(', ', $ids);
        }
        return false;
    }

    public function getViewOrderUrl($orderId)
    {
        return $this->getUrl('sales/order/view/', array('order_id' => $orderId, '_secure' => true));
    }

    public function getContinueUrl()
    {
        return Mage::getBaseUrl();
    }
}
