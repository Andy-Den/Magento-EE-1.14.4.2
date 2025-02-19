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
 * Abstract API2 class for order address
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
abstract class Mage_Sales_Model_Api2_Order_Address_Rest extends Mage_Sales_Model_Api2_Order_Address
{
    /**#@+
     * Parameters in request used in model (usually specified in route mask)
     */
    const PARAM_ORDER_ID     = 'order_id';
    const PARAM_ADDRESS_TYPE = 'address_type';
    /**#@-*/

    /**
     * Retrieve order address
     *
     * @return array
     */
    protected function _retrieve()
    {
        /** @var $address Mage_Sales_Model_Order_Address */
        $address = $this->_getCollectionForRetrieve()
            ->addAttributeToFilter('address_type', $this->getRequest()->getParam(self::PARAM_ADDRESS_TYPE))
            ->getFirstItem();
        if (!$address->getId()) {
            $this->_critical(self::RESOURCE_NOT_FOUND);
        }
        return $address->getData();
    }

    /**
     * Retrieve order addresses
     *
     * @return array
     */
    protected function _retrieveCollection()
    {
        $collection = $this->_getCollectionForRetrieve();

        $this->_applyCollectionModifiers($collection);
        $data = $collection->load()->toArray();

        if (0 == count($data['items'])) {
            $this->_critical(self::RESOURCE_NOT_FOUND);
        }

        return $data['items'];
    }

    /**
     * Retrieve collection instances
     *
     * @return Mage_Sales_Model_Resource_Order_Address_Collection
     */
    protected function _getCollectionForRetrieve()
    {
        /* @var $collection Mage_Sales_Model_Resource_Order_Address_Collection */
        $collection = Mage::getResourceModel('sales/order_address_collection');
        $collection->addAttributeToFilter('parent_id', $this->getRequest()->getParam(self::PARAM_ORDER_ID));

        return $collection;
    }
}
