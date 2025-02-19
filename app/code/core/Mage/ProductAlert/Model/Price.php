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
 * @package     Mage_ProductAlert
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * ProductAlert for changed price model
 *
 * @method Mage_ProductAlert_Model_Resource_Price _getResource()
 * @method Mage_ProductAlert_Model_Resource_Price getResource()
 * @method int getCustomerId()
 * @method Mage_ProductAlert_Model_Price setCustomerId(int $value)
 * @method int getProductId()
 * @method Mage_ProductAlert_Model_Price setProductId(int $value)
 * @method float getPrice()
 * @method Mage_ProductAlert_Model_Price setPrice(float $value)
 * @method int getWebsiteId()
 * @method Mage_ProductAlert_Model_Price setWebsiteId(int $value)
 * @method string getAddDate()
 * @method Mage_ProductAlert_Model_Price setAddDate(string $value)
 * @method string getLastSendDate()
 * @method Mage_ProductAlert_Model_Price setLastSendDate(string $value)
 * @method int getSendCount()
 * @method Mage_ProductAlert_Model_Price setSendCount(int $value)
 * @method int getStatus()
 * @method Mage_ProductAlert_Model_Price setStatus(int $value)
 *
 * @category    Mage
 * @package     Mage_ProductAlert
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_ProductAlert_Model_Price extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('productalert/price');
    }

    public function getCustomerCollection()
    {
        return Mage::getResourceModel('productalert/price_customer_collection');
    }

    public function loadByParam()
    {
        if (!is_null($this->getProductId()) && !is_null($this->getCustomerId()) && !is_null($this->getWebsiteId())) {
            $this->getResource()->loadByParam($this);
        }
        return $this;
    }

    public function deleteCustomer($customerId, $websiteId = 0)
    {
        $this->getResource()->deleteCustomer($this, $customerId, $websiteId);
        return $this;
    }
}
