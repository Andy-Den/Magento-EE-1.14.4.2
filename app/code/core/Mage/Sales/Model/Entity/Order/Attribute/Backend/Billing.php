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
 * Order billing address backend
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_Sales_Model_Entity_Order_Attribute_Backend_Billing extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Before save order billing address process
     *
     * @param Mage_Sales_Model_Order $object
     * @return Mage_Sales_Model_Entity_Order_Attribute_Backend_Billing
     */
    public function beforeSave($object)
    {
        $billingAddressId = $object->getBillingAddressId();
        if (is_null($billingAddressId)) {
            $object->unsetBillingAddressId();
        }
        return $this;
    }

    /**
     * After save order billing address process
     *
     * @param Mage_Sales_Model_Order $object
     * @return Mage_Sales_Model_Entity_Order_Attribute_Backend_Billing
     */
    public function afterSave($object)
    {
        $billingAddressId = false;
        foreach ($object->getAddressesCollection() as $address) {
            /* @var $address Mage_Sales_Model_Order_Address */
            if ('billing' == $address->getAddressType()) {
                $billingAddressId = $address->getId();
            }
        }

        if ($billingAddressId) {
            $object->setBillingAddressId($billingAddressId);
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getAttributeCode());
        }

        return $this;
    }

}
