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
 * @package     Mage_Customer
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/**
 * Customer address api V2
 *
 * @category   Mage
 * @package    Mage_Customer
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Customer_Model_Address_Api_V2 extends Mage_Customer_Model_Address_Api
{
    /**
     * Create new address for customer
     *
     * @param int $customerId
     * @param array $addressData
     * @return int
     */
    public function create($customerId, $addressData)
    {
        $customer = Mage::getModel('customer/customer')
            ->load($customerId);
        /* @var $customer Mage_Customer_Model_Customer */

        if (!$customer->getId()) {
            $this->_fault('customer_not_exists');
        }

        $address = Mage::getModel('customer/address');

        foreach ($this->getAllowedAttributes($address) as $attributeCode=>$attribute) {
            if (isset($addressData->$attributeCode)) {
                $address->setData($attributeCode, $addressData->$attributeCode);
            }
        }

        if (isset($addressData->is_default_billing)) {
            $address->setIsDefaultBilling($addressData->is_default_billing);
        }

        if (isset($addressData->is_default_shipping)) {
            $address->setIsDefaultShipping($addressData->is_default_shipping);
        }

        $address->setCustomerId($customer->getId());

        $valid = $address->validate();

        if (is_array($valid)) {
            $this->_fault('data_invalid', implode("\n", $valid));
        }

        try {
            $address->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }

        return $address->getId();
    }

    /**
     * Retrieve address data
     *
     * @param int $addressId
     * @return array
     */
    public function info($addressId)
    {
        $address = Mage::getModel('customer/address')
            ->load($addressId);

        if (!$address->getId()) {
            $this->_fault('not_exists');
        }

        $result = array();

        foreach ($this->_mapAttributes as $attributeAlias => $attributeCode) {
            $result[$attributeAlias] = $address->getData($attributeCode);
        }

        foreach ($this->getAllowedAttributes($address) as $attributeCode => $attribute) {
            $result[$attributeCode] = $address->getData($attributeCode);
        }


        if ($customer = $address->getCustomer()) {
            $result['is_default_billing']  = $customer->getDefaultBilling() == $address->getId();
            $result['is_default_shipping'] = $customer->getDefaultShipping() == $address->getId();
        }

        return $result;
    }

    /**
     * Update address data
     *
     * @param int $addressId
     * @param array $addressData
     * @return boolean
     */
    public function update($addressId, $addressData)
    {
        $address = Mage::getModel('customer/address')
            ->load($addressId);

        if (!$address->getId()) {
            $this->_fault('not_exists');
        }

        foreach ($this->getAllowedAttributes($address) as $attributeCode=>$attribute) {
            if (isset($addressData->$attributeCode)) {
                $address->setData($attributeCode, $addressData->$attributeCode);
            }
        }

        if (isset($addressData->is_default_billing)) {
            $address->setIsDefaultBilling($addressData->is_default_billing);
        }

        if (isset($addressData->is_default_shipping)) {
            $address->setIsDefaultShipping($addressData->is_default_shipping);
        }

        $valid = $address->validate();
        if (is_array($valid)) {
            $this->_fault('data_invalid', implode("\n", $valid));
        }

        try {
            $address->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }

        return true;
    }

    /**
     * Delete address
     *
     * @param int $addressId
     * @return boolean
     */
    public function delete($addressId)
    {
        $address = Mage::getModel('customer/address')
            ->load($addressId);

        if (!$address->getId()) {
            $this->_fault('not_exists');
        }

        try {
            $address->delete();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('not_deleted', $e->getMessage());
        }

        return true;
    }
} // Class Mage_Customer_Model_Address_Api End
