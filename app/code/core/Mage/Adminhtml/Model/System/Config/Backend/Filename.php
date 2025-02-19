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


class Mage_Adminhtml_Model_System_Config_Backend_Filename extends Mage_Core_Model_Config_Data
{

    /**
     * Config path for system log file.
     */
    const DEV_LOG_FILE_PATH = 'dev/log/file';

    /**
     * Config path for exception log file.
     */
    const DEV_LOG_EXCEPTION_FILE_PATH = 'dev/log/exception_file';

    /**
     * Processing object before save data
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Filename
     * @throws Mage_Core_Exception
     */
    protected function _beforeSave()
    {
        $value      = $this->getValue();
        $configPath = $this->getPath();
        $value      = basename($value);

        // if dev/log setting, validate log file extension.
        if ($configPath == self::DEV_LOG_FILE_PATH || $configPath == self::DEV_LOG_EXCEPTION_FILE_PATH) {
            if (!Mage::helper('log')->isLogFileExtensionValid($value)) {
                throw Mage::exception('Mage_Core', Mage::helper('adminhtml')->__
                ('Invalid file extension used for log file. Allowed file extensions: log, txt, html, csv'));
            }
        }

        $this->setValue($value);
        return $this;
    }
}
