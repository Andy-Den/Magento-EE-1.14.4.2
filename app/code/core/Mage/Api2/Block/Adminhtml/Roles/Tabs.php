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
 * @package     Mage_Api2
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Block tabs for role edit page
 *
 * @category   Mage
 * @package    Mage_Api2
 * @author     Magento Core Team <core@magentocommerce.com>
 * @method Mage_Api2_Block_Adminhtml_Roles_Tabs setRole(Mage_Api2_Model_Acl_Global_Role $role)
 * @method Mage_Api2_Model_Acl_Global_Role getRole()
 */
class Mage_Api2_Block_Adminhtml_Roles_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('role_info_tabs');
        $this->setDestElementId('role_edit_form');
        $this->setData('title', Mage::helper('api2')->__('Role Information'));
    }

    /**
     * Hook before html rendering
     *
     * @return Mage_Api2_Block_Adminhtml_Roles_Tabs
     */
    protected function _beforeToHtml()
    {
        $role = $this->getRole();
        if ($role && Mage_Api2_Model_Acl_Global_Role::isSystemRole($role)) {
            $this->setActiveTab('api2_role_section_resources');
        } else {
            $this->setActiveTab('api2_role_section_info');
        }
        return parent::_beforeToHtml();
    }
}
