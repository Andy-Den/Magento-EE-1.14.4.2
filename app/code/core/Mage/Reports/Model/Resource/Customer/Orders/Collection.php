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
 * @package     Mage_Reports
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */


/**
 * Customers by orders Report collection
 *
 * @category    Mage
 * @package     Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Reports_Model_Resource_Customer_Orders_Collection extends Mage_Reports_Model_Resource_Order_Collection
{
    protected function _construct()
    {
        parent::_construct();
        $this->_useAnalyticFunction = true;
    }
    /**
     * Join fields
     *
     * @param string $from
     * @param string $to
     * @return Mage_Reports_Model_Resource_Customer_Orders_Collection
     */
    protected function _joinFields($from = '', $to = '')
    {
        $this->joinCustomerName()
            ->groupByCustomer()
            ->addOrdersCount()
            ->addAttributeToFilter('created_at', array('from' => $from, 'to' => $to, 'datetime' => true));
        return $this;
    }

    /**
     * Set date range
     *
     * @param string $from
     * @param string $to
     * @return Mage_Reports_Model_Resource_Customer_Orders_Collection
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()
            ->_joinFields($from, $to);
        return $this;
    }

    /**
     * Set store filter to collection
     *
     * @param array $storeIds
     * @return Mage_Reports_Model_Resource_Customer_Orders_Collection
     */
    public function setStoreIds($storeIds)
    {
        if ($storeIds) {
            $this->addAttributeToFilter('store_id', array('in' => (array)$storeIds));
            $this->addSumAvgTotals(1)
                ->orderByOrdersCount();
        } else {
            $this->addSumAvgTotals()
                ->orderByOrdersCount();
        }

        return $this;
    }
}
