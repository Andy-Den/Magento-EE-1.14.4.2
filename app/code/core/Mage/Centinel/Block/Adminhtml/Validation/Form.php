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
 * @package     Mage_Centinel
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Adminhtml sales order create validation card block
 *
 * @category   Mage
 * @package    Mage_Centinel
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Centinel_Block_Adminhtml_Validation_Form extends Mage_Adminhtml_Block_Sales_Order_Create_Abstract
{
    /**
     * Prepare validation and template parameters
     */
    protected function _toHtml()
    {
        $payment = $this->getQuote()->getPayment();
        if ($payment && $method = $payment->getMethodInstance()) {
            if ($method->getIsCentinelValidationEnabled() && $centinel = $method->getCentinelValidator()) {
                $this->setFrameUrl($centinel->getValidatePaymentDataUrl())
                    ->setContainerId('centinel_authenticate_iframe')
                    ->setMethodCode($method->getCode())
                ;
                return parent::_toHtml();
            }
        }
        return '';
    }
}

