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
 * @package     Mage_Tax
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

/**
 * Modify tax report aggregation table to have the tax percent field as part of unique key,
 * because tax rate can be changed (code will remain the same) and it will not be reflected in statistics
 * Data has to be truncated to avoid possible duplicates and then reaggregated to reflect the correct data
 */
$table = $installer->getTable('tax/tax_order_aggregated_created');
$installer->getConnection()->truncate($table);
$installer->getConnection()->addKey($table, 'UNQ_PERIOD_STORE_CODE_ORDER_STATUS',
    array('period', 'store_id', 'code', 'percent', 'order_status'), 'unique'
);
