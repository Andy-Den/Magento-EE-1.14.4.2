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
 * @package     Mage_Weee
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */
class Mage_Weee_Model_Config_Source_Fpt_Tax
{
    /**
     * Array of options for FPT Tax Configuration
     *
     * @return array
     */
    public function toOptionArray()
    {
        $weeeHelper = $this->_getHelper('weee');
        return array(
            array('value' => 0, 'label' => $weeeHelper->__('Not Taxed')),
            array('value' => 1, 'label' => $weeeHelper->__('Taxed')),
            array('value' => 2, 'label' => $weeeHelper->__('Loaded and Displayed with Tax')),
        );
    }

    /**
     * Return helper corresponding to given name
     *
     * @param string $helperName
     * @return Mage_Core_Helper_Abstract
     */
    protected function _getHelper($helperName)
    {
        return Mage::helper($helperName);
    }
}


