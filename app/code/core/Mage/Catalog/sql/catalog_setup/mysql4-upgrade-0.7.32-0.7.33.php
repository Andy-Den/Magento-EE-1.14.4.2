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
 * @package     Mage_Catalog
 * @copyright Copyright (c) 2006-2019 Magento, Inc. (http://www.magento.com)
 * @license http://www.magento.com/license/enterprise-edition
 */

$installer = $this;
/* @var $installer Mage_Catalog_Model_Resource_Eav_Mysql4_Setup */

$attributeId    = $installer->getAttributeId('catalog_category', 'is_active');
$entityTypeId   = $installer->getEntityTypeId('catalog_category');
$installer->updateAttribute('catalog_category', 'is_active', 'backend_type', 'int');

$categoryIntTable = $installer->getTable('catalog_category_entity_int');
$categoryTable = $installer->getTable('catalog_category_entity');
$attributesCount = $installer->getConnection()->fetchOne("SELECT count(*) FROM `{$categoryIntTable}` WHERE attribute_id='{$attributeId}'");
$valueId = $installer->getConnection()->fetchOne("SELECT MAX(value_id) FROM `{$categoryIntTable}`");
if (!$attributesCount) {
    $data = $installer->getConnection()->fetchAll("SELECT {$entityTypeId} as entity_type_id, {$attributeId} as attribute_id, 0 as store_id, entity_id, is_active as value FROM `{$categoryTable}`");
    foreach ($data as $row) {
        $row['value_id'] = ++$valueId;
        $data = $installer->getConnection()->insert($categoryIntTable, $row);
    }
}

