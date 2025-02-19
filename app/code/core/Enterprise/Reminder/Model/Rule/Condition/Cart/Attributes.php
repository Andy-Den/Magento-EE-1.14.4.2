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
 * @package     Enterprise_Reminder
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Cart items attributes subselection condition
 */
class Enterprise_Reminder_Model_Rule_Condition_Cart_Attributes
    extends Enterprise_Reminder_Model_Condition_Abstract
{
    protected $_inputType = 'numeric';

    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('enterprise_reminder/rule_condition_cart_attributes');
        $this->setValue(null);
    }

    /**
     * Get information for being presented in condition list
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        return array('value' => $this->getType(),
            'label' => Mage::helper('enterprise_reminder')->__('Numeric Attribute'));
    }

    /**
     * Init available options list
     *
     * @return Enterprise_Reminder_Model_Rule_Condition_Cart_Attributes
     */
    public function loadAttributeOptions()
    {
        $this->setAttributeOption(array(
            'weight' => Mage::helper('enterprise_reminder')->__('weight'),
            'row_weight' => Mage::helper('enterprise_reminder')->__('row weight'),
            'qty' => Mage::helper('enterprise_reminder')->__('quantity'),
            'price' => Mage::helper('enterprise_reminder')->__('base price'),
            'base_cost' => Mage::helper('enterprise_reminder')->__('base cost')
        ));
        return $this;
    }

    /**
     * Condition string on conditions page
     *
     * @return string
     */
    public function asHtml()
    {
        return $this->getTypeElementHtml()
            . Mage::helper('enterprise_reminder')->__('Item %s %s %s:', $this->getAttributeElementHtml(), $this->getOperatorElementHtml(), $this->getValueElementHtml())
            . $this->getRemoveLinkHtml();
    }

    /**
     * Build condition limitations sql string for specific website
     *
     * @param $customer
     * @param int | Zend_Db_Expr $website
     * @return Varien_Db_Select
     */
    public function getConditionsSql($customer, $website)
    {
        $quoteTable = $this->getResource()->getTable('sales/quote');
        $quoteItemTable = $this->getResource()->getTable('sales/quote_item');
        $operator = $this->getResource()->getSqlOperator($this->getOperator());

        $select = $this->getResource()->createSelect();
        $select->from(array('item' => $quoteItemTable), array(new Zend_Db_Expr(1)));

        $select->joinInner(
            array('quote' => $quoteTable),
            'item.quote_id = quote.entity_id',
            array()
        );

        switch ($this->getAttribute()) {
            case 'weight':
                $field = 'item.weight';
                break;
            case 'row_weight':
                $field = 'item.row_weight';
                break;
            case 'qty':
                $field = 'item.qty';
                break;
            case 'price':
                $field = 'item.price';
                break;
            case 'base_cost':
                $field = 'item.base_cost';
                break;
            default:
                Mage::throwException(Mage::helper('enterprise_reminder')->__('Unknown attribute specified'));
        }

        $this->_limitByStoreWebsite($select, $website, 'quote.store_id');
        $select->where('quote.is_active = 1');
        $select->where("{$field} {$operator} ?", $this->getValue());
        $select->where($this->_createCustomerFilter($customer, 'quote.customer_id'));
        Mage::getResourceHelper('enterprise_reminder')->setRuleLimit($select, 1);
        return $select;
    }
}
