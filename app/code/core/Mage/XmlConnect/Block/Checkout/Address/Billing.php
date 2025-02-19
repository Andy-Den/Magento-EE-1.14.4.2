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
 * One page checkout billing addresses xml renderer
 *
 * @category    Mage
 * @package     Mage_XmlConnect
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_XmlConnect_Block_Checkout_Address_Billing extends Mage_Checkout_Block_Onepage_Billing
{
    /**
     * Render billing addresses xml
     *
     * @return string
     */
    protected function _toHtml()
    {
        /** @var $billingXmlObj Mage_XmlConnect_Model_Simplexml_Element */
        $billingXmlObj = Mage::getModel('xmlconnect/simplexml_element', '<billing></billing>');

        $addressId = $this->getAddress()->getId();
        $address = $this->getCustomer()->getPrimaryBillingAddress();
        if ($address) {
            $addressId = $address->getId();
        }

        foreach ($this->getCustomer()->getAddresses() as $address) {
            $item = $billingXmlObj->addChild('item');
            if ($addressId == $address->getId()) {
                $item->addAttribute('selected', 1);
            }
            $this->getChild('address_list')->prepareAddressData($address, $item);
            $item->addChild('address_line', $billingXmlObj->escapeXml($address->format('oneline')));
        }

        return $billingXmlObj->asNiceXml();
    }
}
