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

$installer = $this;
/* @var $installer Mage_Tax_Model_Mysql4_Setup */

$installer->startSetup();

$table = $installer->getTable('tax_calculation_rate');

$installer->getConnection()->addColumn($table, 'zip_is_range', "TINYINT(1) DEFAULT NULL");
$installer->getConnection()->addColumn($table, 'zip_from', "VARCHAR(10) DEFAULT NULL");
$installer->getConnection()->addColumn($table, 'zip_to', "VARCHAR(10) DEFAULT NULL");

$installer->getConnection()->addKey($table, 'IDX_TAX_CALCULATION_RATE_RANGE', array('tax_calculation_rate_id', 'tax_country_id', 'tax_region_id', 'zip_is_range', 'tax_postcode'));

$installer->endSetup();
