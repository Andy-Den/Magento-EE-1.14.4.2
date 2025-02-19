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
 * Admin Application Settings Tabs block
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Adminhtml_Admin_Application_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Setting tab id, DOM destination element id, title
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('admin_application_app_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle($this->__('Admin Mobile Application'));
    }

    /**
     * Preparing global layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        $this->addTab('set', array(
            'label'     => $this->__('Settings'),
            'content'   => $this->getLayout()->createBlock('xmlconnect/adminhtml_admin_application_edit_tab_settings')
                ->toHtml(),
            'active'    => true
        ));
        return parent::_prepareLayout();
    }
}
