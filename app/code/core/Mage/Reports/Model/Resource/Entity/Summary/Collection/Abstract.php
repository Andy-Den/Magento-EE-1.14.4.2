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
 * Reports summary collection
 *
 * @category    Mage
 * @package     Mage_Reports
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Reports_Model_Resource_Entity_Summary_Collection_Abstract extends Varien_Data_Collection
{
    /**
     * Entity collection for summaries
     *
     * @var Mage_Entity_Model_Entity_Collection_Abstract
     */
    protected $_entityCollection;

    /**
     * Filters the summaries by some period
     *
     * @param string $periodType
     * @param string|int|null $customStart
     * @param string|int|null $customEnd
     * @return Mage_Reports_Model_Resource_Entity_Summary_Collection_Abstract
     */
    public function setSelectPeriod($periodType, $customStart = null, $customEnd = null)
    {
        switch ($periodType) {
            case "24h":
                $customStart = Varien_Date::toTimestamp(true) - 86400;
                $customEnd   = Varien_Date::toTimestamp(true);
                break;

            case "7d":
                $customStart = Varien_Date::toTimestamp(true) - 604800;
                $customEnd   = Varien_Date::toTimestamp(true);
                break;

            case "30d":
                $customStart = Varien_Date::toTimestamp(true) - 2592000;
                $customEnd   = Varien_Date::toTimestamp(true);
                break;

            case "1y":
                $customStart = Varien_Date::toTimestamp(true) - 31536000;
                $customEnd   = Varien_Date::toTimestamp(true);
                break;

            default:
                if (is_string($customStart)) {
                    $customStart = strtotime($customStart);
                }
                if (is_string($customEnd)) {
                    $customEnd = strtotime($customEnd);
                }
                break;

        }


        return $this;
    }

    /**
     * Set date period
     *
     * @param int $period
     * @return Mage_Reports_Model_Resource_Entity_Summary_Collection_Abstract
     */
    public function setDatePeriod($period)
    {
        return $this;
    }

    /**
     * Set store filter
     *
     * @param int $storeId
     * @return Mage_Reports_Model_Resource_Entity_Summary_Collection_Abstract
     */
    public function setStoreFilter($storeId)
    {
        return $this;
    }

    /**
     * Return collection for summaries
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getCollection()
    {
        if (empty($this->_entityCollection)) {
            $this->_initCollection();
        }
        return $this->_entityCollection;
    }

    /**
     * Init collection
     *
     * @return Mage_Reports_Model_Resource_Entity_Summary_Collection_Abstract
     */
    protected function _initCollection()
    {
        return $this;
    }
}
