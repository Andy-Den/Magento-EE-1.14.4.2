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

$attributes = array(
    $installer->getAttributeId('catalog_product', 'price'),
    $installer->getAttributeId('catalog_product', 'special_price'),
    $installer->getAttributeId('catalog_product', 'special_from_date'),
    $installer->getAttributeId('catalog_product', 'special_to_date'),
    $installer->getAttributeId('catalog_product', 'cost'),
    $installer->getAttributeId('catalog_product', 'tier_price'),
);

$sql    = $installer->getConnection()->quoteInto("SELECT * FROM `{$installer->getTable('eav_attribute')}` WHERE attribute_id IN (?)", $attributes);
$data   = $installer->getConnection()->fetchAll($sql);

foreach ($data as $row) {
    $row['apply_to'] = array_flip(explode(',', $row['apply_to']));
    unset($row['apply_to']['grouped']);
    $row['apply_to'] = implode(',', array_flip($row['apply_to']));

    $installer->run("UPDATE `{$installer->getTable('eav_attribute')}`
                SET `apply_to` = '{$row['apply_to']}'
                WHERE `attribute_id` = {$row['attribute_id']}");
}
