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
 * @package     Mage_Log
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Prepare Log Online Visitors Model
 *
 * @method Mage_Log_Model_Resource_Visitor_Online _getResource()
 * @method Mage_Log_Model_Resource_Visitor_Online getResource()
 * @method string getVisitorType()
 * @method Mage_Log_Model_Visitor_Online setVisitorType(string $value)
 * @method int getRemoteAddr()
 * @method Mage_Log_Model_Visitor_Online setRemoteAddr(int $value)
 * @method string getFirstVisitAt()
 * @method Mage_Log_Model_Visitor_Online setFirstVisitAt(string $value)
 * @method string getLastVisitAt()
 * @method Mage_Log_Model_Visitor_Online setLastVisitAt(string $value)
 * @method int getCustomerId()
 * @method Mage_Log_Model_Visitor_Online setCustomerId(int $value)
 * @method string getLastUrl()
 * @method Mage_Log_Model_Visitor_Online setLastUrl(string $value)
 *
 * @category    Mage
 * @package     Mage_Log
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Log_Model_Visitor_Online extends Mage_Core_Model_Abstract
{
    const XML_PATH_ONLINE_INTERVAL      = 'customer/online_customers/online_minutes_interval';
    const XML_PATH_UPDATE_FREQUENCY     = 'log/visitor/online_update_frequency';

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('log/visitor_online');
    }

    /**
     * Retrieve resource instance wrapper
     *
     * @return Mage_Log_Model_Mysql4_Visitor_Online
     */
    protected function _getResource()
    {
        return parent::_getResource();
    }

    /**
     * Prepare Online visitors collection
     *
     * @return Mage_Log_Model_Visitor_Online
     */
    public function prepare()
    {
        $this->_getResource()->prepare($this);
        return $this;
    }

    /**
     * Retrieve last prepare at timestamp
     *
     * @return int
     */
    public function getPrepareAt()
    {
        return Mage::app()->loadCache('log_visitor_online_prepare_at');
    }

    /**
     * Set Prepare at timestamp (if time is null, set current timestamp)
     *
     * @param int $time
     * @return Mage_Log_Model_Mysql4_Visitor_Online
     */
    public function setPrepareAt($time = null)
    {
        if (is_null($time)) {
            $time = time();
        }
        Mage::app()->saveCache($time, 'log_visitor_online_prepare_at');
        return $this;
    }

    /**
     * Retrieve data update Frequency in second
     *
     * @return int
     */
    public function getUpdateFrequency()
    {
        return Mage::getStoreConfig(self::XML_PATH_UPDATE_FREQUENCY);
    }

    /**
     * Retrieve Online Interval (in minutes)
     *
     * @return int
     */
    public function getOnlineInterval()
    {
        $value = intval(Mage::getStoreConfig(self::XML_PATH_ONLINE_INTERVAL));
        if (!$value) {
            $value = Mage_Log_Model_Visitor::DEFAULT_ONLINE_MINUTES_INTERVAL;
        }
        return $value;
    }
}
