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
 * Xmlconnect system config base url model
 *
 * @category    Mage
 * @package     Mage_Xmlconnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Model_Adminhtml_System_Config_Backend_Baseurl
    extends Mage_Adminhtml_Model_System_Config_Backend_Baseurl
{
    /**
     * Update all applications "updated at" parameter with current date
     *
     * @return Mage_XmlConnect_Model_Adminhtml_System_Config_Backend_Baseurl
     */
    protected function _afterSave()
    {
        parent::_afterSave();
        if ($this->isValueChanged()) {
            Mage::getModel('xmlconnect/application')->updateAllAppsUpdatedAtParameter();
        }
        return $this;
    }
}
