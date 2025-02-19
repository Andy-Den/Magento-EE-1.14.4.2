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
 * Sales Mysql resource helper model
 *
 * @category    Mage
 * @package     Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Sales_Model_Resource_Helper_Mysql4 extends Mage_Core_Model_Resource_Helper_Mysql4
    implements Mage_Sales_Model_Resource_Helper_Interface
{
    /**
     * Update rating position
     *
     * @param string $aggregation One of Mage_Sales_Model_Resource_Report_Bestsellers::AGGREGATION_XXX constants
     * @param array $aggregationAliases
     * @param string $mainTable
     * @param string $aggregationTable
     * @return Mage_Sales_Model_Resource_Helper_Abstract
     */
    public function getBestsellersReportUpdateRatingPos($aggregation, $aggregationAliases,
        $mainTable, $aggregationTable
    ) {
        /** @var $reportsResourceHelper Mage_Reports_Model_Resource_Helper_Interface */
        $reportsResourceHelper = Mage::getResourceHelper('reports');

        if ($aggregation == $aggregationAliases['monthly']) {
            $reportsResourceHelper
                ->updateReportRatingPos('month', 'qty_ordered', $mainTable, $aggregationTable);
        } elseif ($aggregation == $aggregationAliases['yearly']) {
            $reportsResourceHelper
                ->updateReportRatingPos('year', 'qty_ordered', $mainTable, $aggregationTable);
        } else {
            $reportsResourceHelper
                ->updateReportRatingPos('day', 'qty_ordered', $mainTable, $aggregationTable);
        }

        return $this;
    }
}
