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
 * @package     Mage_Sales
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Billing agreements resource collection
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Resource_Billing_Agreement_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Mapping for fields
     *
     * @var array
     */
    protected $_map = array('fields' => array(
        'customer_email'       => 'ce.email',
        'customer_firstname'   => 'firstname.value',
        'customer_middlename'  => 'middlename.value',
        'customer_lastname'    => 'lastname.value',
        'agreement_created_at' => 'main_table.created_at',
        'agreement_updated_at' => 'main_table.updated_at',
    ));

    /**
     * Collection initialization
     *
     */
    protected function _construct()
    {
        $this->_init('sales/billing_agreement');
    }

    /**
     * Add cutomer details(email, firstname, lastname) to select
     *
     * @return Mage_Sales_Model_Resource_Billing_Agreement_Collection
     */
    public function addCustomerDetails()
    {
        $select = $this->getSelect()->joinInner(
            array('ce' => $this->getTable('customer/entity')),
            'ce.entity_id = main_table.customer_id',
            array('customer_email' => 'email')
        );

        $customer = Mage::getResourceSingleton('customer/customer');
        $adapter  = $this->getConnection();
        $attr     = $customer->getAttribute('firstname');
        $joinExpr = 'firstname.entity_id = main_table.customer_id AND '
            . $adapter->quoteInto('firstname.entity_type_id = ?', $customer->getTypeId()) . ' AND '
            . $adapter->quoteInto('firstname.attribute_id = ?', $attr->getAttributeId()
        );

        $select->joinLeft(
            array('firstname' => $attr->getBackend()->getTable()),
            $joinExpr,
            array('customer_firstname' => 'value')
        );

        $attr     = $customer->getAttribute('middlename');
        $joinExpr = 'middlename.entity_id = main_table.customer_id AND '
            . $adapter->quoteInto('middlename.entity_type_id = ?', $customer->getTypeId()) . ' AND '
            . $adapter->quoteInto('middlename.attribute_id = ?', $attr->getAttributeId());

        $select->joinLeft(
            array('middlename' => $attr->getBackend()->getTable()),
            $joinExpr,
            array('customer_middlename' => 'value')
        );

        $attr = $customer->getAttribute('lastname');
        $joinExpr = 'lastname.entity_id = main_table.customer_id AND '
            . $adapter->quoteInto('lastname.entity_type_id = ?', $customer->getTypeId()) . ' AND '
            . $adapter->quoteInto('lastname.attribute_id = ?', $attr->getAttributeId());

        $select->joinLeft(
            array('lastname' => $attr->getBackend()->getTable()),
            $joinExpr,
            array('customer_lastname' => 'value')
        );
        return $this;
    }
}
