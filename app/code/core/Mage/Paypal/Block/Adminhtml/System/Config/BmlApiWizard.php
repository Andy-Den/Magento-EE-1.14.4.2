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
 * Custom renderer for PayPal BML credentials wizard popup
 */
class Mage_Paypal_Block_Adminhtml_System_Config_BmlApiWizard extends Mage_Paypal_Block_Adminhtml_System_Config_ApiWizard
{
    /**
     * @var string
     */
    protected $_wizardTemplate = 'paypal/system/config/bml_api_wizard.phtml';

    /**
     * No sandbox button for BmlApiWizard
     *
     * @param string $elementHtmlId
     * @param array $originalData
     * @return array
     */
    protected function _getSandboxButtonData($elementHtmlId, $originalData)
    {
        return array();
    }
}
