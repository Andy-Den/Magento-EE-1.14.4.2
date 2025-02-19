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
 * @package     Enterprise_CatalogPermissions
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Permission resource model
 *
 * @category    Enterprise
 * @package     Enterprise_CatalogPermissions
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Enterprise_CatalogPermissions_Model_Resource_Permission extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource
     *
     */
    protected function _construct()
    {
        $this->_init('enterprise_catalogpermissions/permission', 'permission_id');
    }

    /**
     * Initialize unique scope for permission
     *
     */
    protected function _initUniqueFields()
    {
        parent::_initUniqueFields();
        $this->_uniqueFields[] = array(
            'field' => array('category_id', 'website_id', 'customer_group_id'),
            'title' => Mage::helper('enterprise_catalogpermissions')->__('Permission with the same scope')
        );
    }
}
