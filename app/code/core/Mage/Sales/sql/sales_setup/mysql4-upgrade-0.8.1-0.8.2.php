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

/* @var $installer Mage_Sales_Model_Entity_Setup */

$installer->startSetup();

try {
    $installer->run("
    ALTER TABLE {$this->getTable('sales_order_entity_varchar')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_order_entity_varchar_store`, DROP FOREIGN KEY `FK_sales_order_entity_varchar_store`;
    ALTER TABLE {$this->getTable('sales_order_entity_text')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_order_entity_text_store`, DROP FOREIGN KEY `FK_sales_order_entity_text_store`;
    ALTER TABLE {$this->getTable('sales_order_entity_int')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_order_entity_int_store`, DROP FOREIGN KEY `FK_sales_order_entity_int_store`;
    ALTER TABLE {$this->getTable('sales_order_entity_decimal')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_order_entity_decimal_store`, DROP FOREIGN KEY `FK_sales_order_entity_decimal_store`;
    ALTER TABLE {$this->getTable('sales_order_entity_datetime')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_order_entity_datetime_store`, DROP FOREIGN KEY `FK_sales_order_entity_datetime_store`;

    ALTER TABLE {$this->getTable('sales_quote_entity_varchar')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_entity_varchar_store`, DROP FOREIGN KEY `FK_sales_quote_entity_varchar_store`;
    ALTER TABLE {$this->getTable('sales_quote_entity_text')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_entity_text_store`, DROP FOREIGN KEY `FK_sales_quote_entity_text_store`;
    ALTER TABLE {$this->getTable('sales_quote_entity_int')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_entity_int_store`, DROP FOREIGN KEY `FK_sales_quote_entity_int_store`;
    ALTER TABLE {$this->getTable('sales_quote_entity_decimal')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_entity_decimal_store`, DROP FOREIGN KEY `FK_sales_quote_entity_decimal_store`;
    ALTER TABLE {$this->getTable('sales_quote_entity_datetime')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_entity_datetime_store`, DROP FOREIGN KEY `FK_sales_quote_entity_datetime_store`;

    ALTER TABLE {$this->getTable('sales_quote_temp_varchar')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_temp_varchar_store`, DROP FOREIGN KEY `FK_sales_quote_temp_varchar_store`;
    ALTER TABLE {$this->getTable('sales_quote_temp_text')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_temp_text_store`, DROP FOREIGN KEY `FK_sales_quote_temp_text_store`;
    ALTER TABLE {$this->getTable('sales_quote_temp_int')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_temp_int_store`, DROP FOREIGN KEY `FK_sales_quote_temp_int_store`;
    ALTER TABLE {$this->getTable('sales_quote_temp_decimal')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_temp_decimal_store`, DROP FOREIGN KEY `FK_sales_quote_temp_decimal_store`;
    ALTER TABLE {$this->getTable('sales_quote_temp_datetime')} DROP COLUMN `store_id`, DROP INDEX `FK_sales_quote_temp_datetime_store`, DROP FOREIGN KEY `FK_sales_quote_temp_datetime_store`;
    ");
}
catch (Exception $e) {
}

$installer->installEntities();
$installer->endSetup();
