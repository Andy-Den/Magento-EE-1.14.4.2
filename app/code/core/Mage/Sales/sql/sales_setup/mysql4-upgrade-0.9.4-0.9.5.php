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

$installer = $this;
/* @var $installer Mage_Sales_Model_Mysql4_Setup */

$installer->startSetup();
$installer->getConnection()->dropColumn($installer->getTable('sales_flat_quote_item'), 'super_product_id');
$installer->getConnection()->changeColumn($installer->getTable('sales_flat_quote_item'), 'parent_product_id', 'parent_item_id', 'INTEGER UNSIGNED DEFAULT NULL');
$installer->getConnection()->addConstraint('FK_SALES_FLAT_QUOTE_ITEM_PARENT_ITEM',
    $installer->getTable('sales_flat_quote_item'), 'parent_item_id',
    $installer->getTable('sales_flat_quote_item'), 'item_id'
);
$installer->endSetup();
