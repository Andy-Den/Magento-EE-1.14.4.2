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
 * @package     Enterprise_CustomerSegment
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Customer address attributes selector
 */
class Enterprise_CustomerSegment_Model_Segment_Condition_Customer_Address_Attributes
    extends Enterprise_CustomerSegment_Model_Condition_Abstract
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType('enterprise_customersegment/segment_condition_customer_address_attributes');
        $this->setValue(null);
    }

    /**
     * Get array of event names where segment with such conditions combine can be matched
     *
     * @return array
     */
    public function getMatchedEvents()
    {
        return array('customer_address_save_commit_after', 'customer_address_delete_commit_after');
    }

    /**
     * Get inherited conditions selectors
     *
     * @return array
     */
    public function getNewChildSelectOptions()
    {
        $prefix = 'enterprise_customersegment/segment_condition_customer_address_';
        $attributes = $this->loadAttributeOptions()->getAttributeOption();
        $conditions = array();
        foreach ($attributes as $code => $label) {
            $conditions[] = array('value'=> $this->getType() . '|' . $code, 'label'=>$label);
        }
        $conditions = array_merge($conditions, Mage::getModel($prefix . 'region')->getNewChildSelectOptions());
        return array(
            'value' => $conditions,
            'label'=>Mage::helper('enterprise_customersegment')->__('Address Attributes')
        );
    }

    /**
     * Load attribute options
     *
     * @return Enterprise_CustomerSegment_Model_Segment_Condition_Customer_Address_Attributes
     */
    public function loadAttributeOptions()
    {
        $customerAttributes = Mage::getResourceSingleton('customer/address')
            ->loadAllAttributes()
            ->getAttributesByCode();

        $attributes = array();
        foreach ($customerAttributes as $attribute) {
            // skip "binary" attributes
            if (in_array($attribute->getFrontendInput(), array('file', 'image'))) {
                continue;
            }
            if ($attribute->getIsUsedForCustomerSegment()) {
                $attributes[$attribute->getAttributeCode()] = $attribute->getFrontendLabel();
            }
        }

        asort($attributes);
        $this->setAttributeOption($attributes);
        return $this;
    }

    /**
     * Retrieve select option values
     *
     * @return array
     */
    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            switch ($this->getAttribute()) {
                case 'country_id':
                    $options = Mage::getModel('adminhtml/system_config_source_country')
                        ->toOptionArray();
                    break;

                case 'region_id':
                    $options = Mage::getModel('adminhtml/system_config_source_allregion')
                        ->toOptionArray();
                    break;

                default:
                    $options = array();
                    if (!$this->getData('value_select_options') && is_object($this->getAttributeObject())) {
                        if ($this->getAttributeObject()->usesSource()) {
                            if ($this->getAttributeObject()->getFrontendInput() == 'multiselect') {
                                $addEmptyOption = false;
                            } else {
                                $addEmptyOption = true;
                            }
                            $options = $this->getAttributeObject()->getSource()->getAllOptions($addEmptyOption);
                        }
                    }
            }

            $this->setData('value_select_options', $options);
        }

        return $this->getData('value_select_options');
    }

    /**
     * Retrieve attribute element
     *
     * @return Varien_Form_Element_Abstract
     */
    public function getAttributeElement()
    {
        $element = parent::getAttributeElement();
        $element->setShowAsText(true);
        return $element;
    }

    /**
     * Get input type for attribute operators.
     *
     * @return string
     */
    public function getInputType()
    {
        if (in_array($this->getAttribute(), array('country_id', 'region_id'))) {
            return 'select';
        }
        if (!is_object($this->getAttributeObject())) {
            return 'string';
        }

        $input = $this->getAttributeObject()->getFrontendInput();
        switch ($input) {
            case 'boolean':
                return 'select';
            case 'select':
            case 'multiselect':
            case 'date':
                return $input;
        }

        return 'string';
    }

    /**
     * Get input type for attribute value.
     *
     * @return string
     */
    public function getValueElementType()
    {
        if (in_array($this->getAttribute(), array('country_id', 'region_id'))) {
            return 'select';
        }
        if (!is_object($this->getAttributeObject())) {
            return 'text';
        }

        $input = $this->getAttributeObject()->getFrontendInput();
        switch ($input) {
            case 'boolean':
                return 'select';
            case 'select':
            case 'multiselect':
            case 'date':
                return $input;
        }

        return 'text';
    }

    /**
     * Get HTML of condition string
     *
     * @return string
     */
    public function asHtml()
    {
        return Mage::helper('enterprise_customersegment')->__('Customer Address %s', parent::asHtml());
    }

    /**
     * Retrieve attribute object
     *
     * @return Mage_Eav_Model_Entity_Attribute
     */
    public function getAttributeObject()
    {
        return Mage::getSingleton('eav/config')->getAttribute('customer_address', $this->getAttribute());
    }

    /**
     * Prepare customer address attribute condition select
     *
     * @param $customer
     * @param $website
     * @return Varien_Db_Select
     */
    public function getConditionsSql($customer, $website)
    {
        $select = $this->getResource()->createSelect();
        $attribute = $this->getAttributeObject();

        $select->from(array('val'=>$attribute->getBackendTable()), array(new Zend_Db_Expr(1)));
        $condition = $this->getResource()->createConditionSql(
            'val.value', $this->getOperator(), $this->getValue()
        );
        $select->where('val.attribute_id = ?', $attribute->getId())
            ->where("val.entity_id = customer_address.entity_id")
            ->where($condition);

        Mage::getResourceHelper('enterprise_customersegment')->setOneRowLimit($select);

        return $select;
    }
}
