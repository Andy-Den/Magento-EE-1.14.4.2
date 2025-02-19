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
 * @package     Mage_Api
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * IP assertion for admin acl
 *
 * @category   Mage
 * @package    Mage_Api
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Api_Model_Acl_Assert_Ip implements Zend_Acl_Assert_Interface
{
    /**
     * Check whether ip is allowed
     *
     * @param Zend_Acl $acl
     * @param Zend_Acl_Role_Interface $role
     * @param Zend_Acl_Resource_Interface $resource
     * @param string $privilege
     * @return boolean
     */
    public function assert(Mage_Api_Model_Acl $acl, Mage_Api_Model_Acl_Role $role = null,
                           Mage_Api_Model_Acl_Resource $resource = null, $privilege = null)
    {
        return $this->_isCleanIP(Mage::helper('core/http')->getRemoteAddr());
    }

    protected function _isCleanIP($ip)
    {
        // ...
    }
}
